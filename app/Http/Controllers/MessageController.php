<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;
use TradefiUBA\MessageInbox;
use TradefiUBA\User;
use TradefiUBA\Staff;
use TradefiUBA\MessageRecipient;
use TradefiUBA\MessageFile;

use Event;
use TradefiUBA\Events\NewMessageEvent;

use Notification;
use TradefiUBA\Notifications\NewMessage;
use TradefiUBA\Notifications\NewPriceUpload;

use DB;
use Storage;
use Carbon;

use Excel;
use TradefiUBA\SimpleXLSX;
use TradefiUBA\PriceUpload;
use TradefiUBA\MessageSubject;
use TradefiUBA\Security;

class MessageController extends Controller
{
  public function inbox()
  {
    $user = auth()->user();
    // $messages = MessageInbox::where('ToID', $user->id)->orderBy('MessageRef', 'desc')->get();
    $messages = $user->inbox()->paginate(20);

    return view('messages.inbox', compact('user', 'messages'));
  }

  public function sent_messages()
  {
    $user = auth()->user();
    $messages = $user->sent_messages()->paginate(20);
    // dd($messages);
    return view('messages.sent', compact('user', 'messages'));
  }

  public function compose()
  {
    $user = auth()->user();

    $users = User::where('admin', true)->where('id', '!=', $user->id)->get();
    $subjects = MessageSubject::all();

    if (!empty($_GET['forward'])) {
      $fw = $_GET['forward'];
      $forward = MessageInbox::find($fw);
    }

    return view('messages.compose', compact('user', 'users', 'forward', 'subjects'));
  }

  // public function forward($id)
  // {
  //   $user = auth()->user();
  //   if ($user->is_superadmin) {
  //     $staffs = Staff::all();
  //   } else {
  //     $staffs = Staff::where('CompanyID', $user->staff->CompanyID)->where('UserID', '!=', $user->id)->get();
  //   }
  //
  //   return view('messages.compose', compact('user', 'staffs'));
  // }

  public function send_message(Request $request)
  {
    $this->validate($request, [
      'Subject' => 'required',
      'Body' => 'required',
    ]);

    function arrayMatch($keyword, $array) {
      foreach($array as $key => $arrayItem){
          if( stristr( $arrayItem, $keyword ) ){
              return $key;
          }
      }
    }

    try {
      DB::beginTransaction();

      $user = auth()->user();
      $message = new MessageInbox;
      $message->FromID = $user->id;
      $message->Subject = $request->Subject;
      $message->Body = $request->Body;
      $message->save();

      foreach ($request->to as $to) {
        $rec = new MessageRecipient;
        $rec->MessageID = $message->MessageRef;
        $rec->UserID = $to;
        $rec->save();
      }

      $isPrice = (bool)(strtolower($request->Subject) == 'price upload');

      if (!empty($request->MessageFiles)) {
        if($isPrice)
        DB::table('tblPriceUpload')->truncate();
        
          
          foreach ($request->MessageFiles as $file) {
            $filename = str_replace(' ', '_', $file->getClientOriginalName() );
            // $saved    = $file->storeAs('meeting_files', $filename);
            // $saved    = Storage::disk('public')->put('message_files/'.$filename, $file);
            $saved    = $file->storeAs('message_files', $filename, 'public');

            if ($saved) {
              $new_file = new MessageFile;
              $new_file->Filename = $filename;
              $new_file->MessageID = $message->MessageRef;
              $new_file->UserID = $user->id;
              $new_file->save();
            }

            if($isPrice) {
                if (in_array($file->extension(), ['xlsx', 'xls', 'csv'])) {
                  // $data = Excel::load($file, function($reader) {
                  //     // Getting all results
                  //     $results = $reader->get();
                  //     dd($results->toArray());
                  //   })->get();
                  //   // dd($data);

                  $path = $file->getRealPath();
                  $xlsx = @(new SimpleXLSX($path));
                  $rows =  $xlsx->rows();
                  // $rows = Excel::load($path, function($reader) {
                  //         })->get();
                  // dd($rows);
                  $clean_rows = [];


                  // dd($rows[2][1]);

                  

                  if(!empty($rows)){
                    
                    foreach ($rows as $key => $row) {
                      // $new_row = array_filter($row);
                      // if(count($new_row) >= 4)
                      // $clean_rows[] = $new_row;
                      // ====
                      // $first_key = arrayMatch('NIG', $row);
                      // if(!empty($first_key))
                      // $clean_rows[] = [ $row[$first_key], $row[$first_key+1], $row[$first_key+2], $row[$first_key+3], $row[$first_key+4] ];
                      // ====
                      if(($key <= 2) || ( empty($row[4]) && empty($row[5]) )){
                        continue;
                      } else {
                        $clean_rows[] = [ $row[1], $row[2], $row[3], $row[4], $row[5] ];
                      }

                    }
                    // array_shift($clean_rows);
                    // dd($clean_rows);

                    foreach ($clean_rows as $row) {
                      $security = Security::where('SecuritiesIdentifier', $row[0])->first();
                      $inv = new PriceUpload;
                      if(!empty($security)) {
                        $inv->MaturityDate = $security->MaturityDate;
                        $inv->SecurityID = $security->SecurityRef;
                      }
                      $inv->SecurityIdentifier = (string)$row[0];
                      $inv->TenorToMaturity = (!empty($row[1]))? $row[1] : ((!empty($security))? (Carbon::parse($security->MaturityDate)->diffInDays(Carbon::now())) : '-');
                      $inv->AmountAvailable = $row[2];
                      $inv->BuyRate = number_format((float)$row[3], 2);
                      $inv->SellRate = number_format((float)$row[4], 2);
                      $inv->InitiatorID = auth()->id();
                      $inv->save();
                    }
                  }

                }

            } // End isPrice

          }
      }




      // $msg = MessageInbox::where('MessageRef', $message->MessageRef)->with('recipients')->first();
      // Notifs
      $msg['from'] = $message->sender->FullName;
      $msg['subject'] = $message->Subject;
      $msg['body'] = str_limit($message->Body, 50);
      // $msg['recipients'] = $message->recipients->pluck('id')->toArray();
      $msg['recipients'] = $request->to;

      DB::commit();

      // Event::fire(new NewMessageEvent($msg));
      Notification::send($message->recipients, new NewMessage($message));
      Notification::route('mail', config('app.tradefi_email_notifications'))->notify(new NewPriceUpload($message, $filename));

      if($isPrice)
        return redirect()->route('confirm_upload')->with('success', 'Your message & file was sent successfully.');
      else
        return redirect()->route('inbox')->with('success', 'Your message was sent successfully.');
    } catch (Exception $e) {
      DB::rollback();
      return redirect()->back()->withInput()->with('error', 'Message sending failed.');
    }

  }

  public function reply_message(Request $request, $parent_id)
  {
    $user = auth()->user();

    $parent = MessageInbox::find($parent_id);

    $this->authorize('view-message', $parent);

    $this->validate($request, [
      'Body' => 'required',
    ]);

    try {
      DB::beginTransaction();

      $message = new MessageInbox;
      $message->FromID = $user->id;
      $message->Subject = 'Re: '.$parent->Subject;
      $message->Body = $request->Body;
      $message->ParentID = $parent_id;
      $message->save();

      // Parent's recipients to array
      $people = $parent->recipients->pluck('id')->toArray();
      // Get reply sender's array key
      $my_key = array_search($user->id, $people);
      if ($user->id == $parent->FromID) {
        // $people = array_diff($people, [$my_key]);
        $people = $people;
      } else {
        // Remove reply sender, replace with parent's sender. (haystack, start_key, count, replacement)
        array_splice($people, $my_key, 1, $parent->FromID);
      }

      foreach ($people as $to) {
        $rec = new MessageRecipient;
        $rec->MessageID = $message->MessageRef;
        $rec->UserID = $to;
        $rec->save();
      }


      if (!empty($request->MessageFiles)) {
          foreach ($request->MessageFiles as $file) {
            $filename = str_replace(' ', '_', $file->getClientOriginalName() );
            // $saved    = $file->storeAs('meeting_files', $filename);
            // $saved    = Storage::disk('public')->put('message_files/'.$filename, $file);
            $saved    = $file->storeAs('message_files', $filename, 'public');

            if ($saved) {
              $new_file = new MessageFile;
              $new_file->Filename = $filename;
              $new_file->MessageID = $message->MessageRef;
              $new_file->UserID = $user->id;
              $new_file->save();
            }

          }
      }

      // Notifs
      $msg['from'] = $message->sender->FullName;
      $msg['subject'] = $message->Subject;
      $msg['body'] = str_limit($message->Body, 50);
      // $msg['recipients'] = $message->recipients->pluck('id')->toArray();
      $msg['recipients'] = $people;

      DB::commit();

      Event::fire(new NewMessageEvent($msg));
      $people_users = User::whereIn('id', $people)->get();
      Notification::send($people_users, new NewMessage($message));

      return redirect()->route('view_message', $parent->MessageRef)->with('success', 'Your reply was sent successfully.');
    } catch (Exception $e) {

      DB::rollback();
      return redirect()->route('view_message', $parent->MessageRef)->with('danger', 'Message sending failed.');
    }

  }

  public function view_message($id, $reply = null)
  {
    $message = MessageInbox::find($id);
    // $message = MessageInbox::where('MessageRef', $id)->with('recipients')->first();
    // dd($message);
    $user = auth()->user();

    $this->authorize('view-message', $message);

    if (!empty($reply)) {
      $msg_read = MessageRecipient::where('MessageID', $reply)->where('UserID', $user->id)->first();
      if (isset($msg_read->IsRead)) {
        DB::statement("UPDATE tblMessageRecipients SET IsRead = 'TRUE' WHERE MessageID = ".$reply." AND UserID = ".$user->id);
      }
    }

    return view('messages.view', compact('message', 'user'));
  }

  public function search_messages()
  {
    $user = auth()->user();
    if (!empty($_GET['q'])) {
      $q = $_GET['q'];
    } else {
      $q = '';
    }
    // $results = MessageInbox::where('Subject', 'LIKE', '%'.$q.'%')->orWhere('Body', 'LIKE', '%'.$q.'%')->paginate(20);
    $results = MessageInbox::where(function($query1) use($user){
      $query1->where('FromID', $user->id)->orWhereHas('recipients', function($query) use($user){
        $query->where('users.id', $user->id);
      });
    })->where(function($query2) use($q){
      $query2->where('Subject', 'LIKE', '%'.$q.'%')->orWhere('Body', 'LIKE', '%'.$q.'%');
    })->paginate(20);
    return view('messages.search', compact('results'));
  }

  public function store_subject(Request $request)
  {
    $subject = new MessageSubject;
    $subject->MessageSubject = $request->MessageSubject;
    $subject->save();

    return $subject;
  }

  public function confirm_upload()
  {
    $staging = PriceUpload::where('ConfirmFlag', false)->get();

    return view('messages.confirm_upload', compact('staging'));
  }

  public function post_confirm_upload()
  {
    PriceUpload::where('ConfirmFlag', false)
    ->update([
      'ConfirmFlag' => true,
      'ConfirmerID' => auth()->id(),
      'ConfirmDate' => date('Y-m-d H:i:s.v')
    ]);

    return redirect()->back()->with('success', 'Confirmed successfully');
  }

}
