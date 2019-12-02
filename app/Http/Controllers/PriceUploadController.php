<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;

use TradefiUBA\PriceUpload;
use TradefiUBA\PriceUploadHistory;
use TradefiUBA\TradeList;
use TradefiUBA\Security;
use TradefiUBA\Inventory;
use TradefiUBA\FootPrint;
use DB;

class PriceUploadController extends Controller
{
  public function first_approval()
  {
    // ***========
    $footprint = (object) [
      'Title' => 'Price Upload - Approval Queue',
      'Details' => 'Approval Queue'
    ];
    FootPrint::logTrail($footprint);
    // ***========

    $staging = PriceUpload::where('ConfirmFlag', true)->where('ApprovedFlag', false)->get();

    return view('messages.first_approval', compact('staging'));
  }

  // public function post_first_approval()
  // {
  //   try {
  //     DB::beginTransaction();
  //     // Approve Data
  //     $uploads = PriceUpload::where('ConfirmFlag', true);
  //     $uploads->update([
  //       'ApproverID' => auth()->id(),
  //       'ApprovedFlag' => true,
  //       'ApprovedDate' => date('Y-m-d H:i:s.v')
  //     ]);
      

  //     // dd(Security::whereIn('MaturityDate', $uploads->pluck('MaturityDate'))->get());
  //     $uploads = PriceUpload::where('ConfirmFlag', true)->get();

  //     // Upload Prices
  //     foreach ($uploads as $upload) {
  //       $security = Security::where('MaturityDate', $upload->MaturityDate)->first();
  //       // dd($security);

  //       if(empty($security))
  //       continue;

  //       $find_buy = TradeList::where('SecurityID', $security->SecurityRef)->where('TransactionTypeID', '1')->first();
  //       $find_sell = TradeList::where('SecurityID', $security->SecurityRef)->where('TransactionTypeID', '2')->first();

  //       if(empty($find_buy)) {
  //         $buy_trade = new TradeList;
  //       } else {
  //         $buy_trade = $find_buy;
  //       }
  //       $buy_trade->SecurityID = $security->SecurityRef;
  //       $buy_trade->TransactionTypeID = '1';
  //       $buy_trade->Quantity = (int)$upload->AmountAvailable; 
  //       $buy_trade->Price = $upload->BuyRate;
  //       $buy_trade->PriceMakerID = '2';
  //       $buy_trade->InputterID = auth()->id();
  //       if(empty($find_buy)) {
  //         $buy_trade->save();
  //       } else {
  //         $buy_trade->ModifiedDatetime = date('Y-m-d H:i:s.v');
  //         $buy_trade->ModifierID = auth()->id();
  //         $buy_trade->update();
  //       }

  //       if(empty($find_sell)) {
  //         $sell_trade = new TradeList;
  //       } else {
  //         $sell_trade = $find_sell;
  //       }
  //       $sell_trade->SecurityID = $security->SecurityRef;
  //       $sell_trade->TransactionTypeID = '2';
  //       $sell_trade->Quantity = (int)$upload->AmountAvailable; 
  //       $sell_trade->Price = $upload->SellRate;
  //       $sell_trade->PriceMakerID = '2';
  //       $sell_trade->InputterID = auth()->id();
  //       if(empty($find_sell)) {
  //         $sell_trade->save();
  //       } else {
  //         $sell_trade->ModifiedDatetime = date('Y-m-d H:i:s.v');
  //         $sell_trade->ModifierID = auth()->id();
  //         $sell_trade->update();
  //       }
        
  //       // Store Prices in History Table
  //       $history = new PriceUploadHistory;
  //       $history->MaturityDate = $upload->MaturityDate;
  //       $history->TenorToMaturity = $upload->TenorToMaturity;
  //       $history->AmountAvailable = $upload->AmountAvailable;
  //       $history->BuyRate = $upload->BuyRate;
  //       $history->SellRate = $upload->SellRate;
  //       $history->InitiatorID = $upload->InitiatorID;
  //       $history->ConfirmerID = $upload->ConfirmerID;
  //       $history->ConfirmDate = $upload->ConfirmDate;
  //       $history->ApproverID = $upload->ApproverID;
  //       $history->ApprovedDate = $upload->ApprovedDate;
  //       $history->created_at = $upload->created_at;
  //       $history->updated_at = $upload->updated_at;
  //       $history->save();

  //       // Remove Inventories today if any, for this security
  //       $old_invs = Inventory::where('SecurityID', $security->SecurityRef)->whereDate('created_at', date('Y-m-d'));
  //       if(count($old_invs->get()) > 0)
  //         $old_invs->delete();

  //       // Store Inventory Buy
  //       $buy_inv = new Inventory;
  //       $buy_inv->SecurityID = $security->SecurityRef;
  //       $buy_inv->TransactionTypeID = '1';
  //       $buy_inv->ModuleID = '4';
  //       $buy_inv->Quantity = (int)$upload->AmountAvailable;
  //       $buy_inv->InputterID = $upload->InitiatorID;
  //       $buy_inv->ApproverID1 = auth()->id();
  //       $buy_inv->NotifyFlag = true;
  //       $buy_inv->ApprovedFlag = true;
  //       $buy_inv->ApprovalDate = $upload->ApprovedDate;
  //       // $buy_inv->TransactionTypeID2 = ?;
  //       $buy_inv->save();

  //       // Store Inventory Sell
  //       $buy_inv = new Inventory;
  //       $buy_inv->SecurityID = $security->SecurityRef;
  //       $buy_inv->TransactionTypeID = '2';
  //       $buy_inv->ModuleID = '4';
  //       $buy_inv->Quantity = (int)$upload->AmountAvailable;
  //       $buy_inv->InputterID = $upload->InitiatorID;
  //       $buy_inv->ApproverID1 = auth()->id();
  //       $buy_inv->NotifyFlag = true;
  //       $buy_inv->ApprovedFlag = true;
  //       $buy_inv->ApprovalDate = $upload->ApprovedDate;
  //       // $buy_inv->TransactionTypeID2 = ?;
  //       $buy_inv->save();

  //     }

      
  //     DB::commit();
  //     return redirect()->route('price_upload.history')->with('success', 'The prices were approved and uploaded successfully');
  //   } catch (Exception $e) {
  //     DB::rollback();
  //     return redirect()->back()->with('danger', 'A problem was encountered trying to upload prices.');
  //   }
  // }


  public function post_first_approval_selected(Request $request)
  {
    // dd($request->all());
    try {
      DB::beginTransaction();
      // Approve Data
      $uploads = PriceUpload::whereIn('PriceUploadRef', $request->selected_ids)->where('ConfirmFlag', true);
      $uploads->update([
        'ApproverID' => auth()->id(),
        'ApprovedFlag' => true,
        'ApprovedDate' => date('Y-m-d H:i:s.v')
      ]);
      

      // dd(Security::whereIn('MaturityDate', $uploads->pluck('MaturityDate'))->get());
      $uploads = PriceUpload::whereIn('PriceUploadRef', $request->selected_ids)->where('ConfirmFlag', true)->get();

      // Upload Prices
      foreach ($uploads as $upload) {
        $security = Security::where('SecuritiesIdentifier', $upload->SecurityIdentifier)->first();
        // dd($security);

        if(empty($security))
        continue;

        $find_buy = TradeList::where('SecurityID', $security->SecurityRef)->where('TransactionTypeID', '1')->first();
        $find_sell = TradeList::where('SecurityID', $security->SecurityRef)->where('TransactionTypeID', '2')->first();

        if(empty($find_buy)) {
          // $buy_trade = new TradeList; // Auto-created on Security creation
        } else {
          $buy_trade = $find_buy;
        }
        $buy_trade->SecurityID = $security->SecurityRef;
        $buy_trade->TransactionTypeID = '1';
        $buy_trade->Quantity = (int)$upload->AmountAvailable;
        if ($security->ProductID == '1') {
          $buy_trade->UBABondYield = $upload->BuyRate;
          // $buy_trade->Price = DB::select("exec procYieldToPrice '$security->SecurityRef', '$upload->BuyRate' ")[0]->price;
        } elseif ($security->ProductID == '2') {
          $buy_trade->Price = $upload->BuyRate;
        }
        // $buy_trade->Price = $upload->BuyRate;
        
        $buy_trade->PriceMakerID = '2';
        $buy_trade->InputterID = auth()->id();
        if(empty($find_buy)) {
          $buy_trade->save();
        } else {
          $buy_trade->ModifiedDatetime = date('Y-m-d H:i:s.v');
          $buy_trade->ModifierID = auth()->id();
          $buy_trade->update();
        }

        if(empty($find_sell)) {
          // $sell_trade = new TradeList; // Auto-created on Security creation
        } else {
          $sell_trade = $find_sell;
        }
        $sell_trade->SecurityID = $security->SecurityRef;
        $sell_trade->TransactionTypeID = '2';
        $sell_trade->Quantity = (int)$upload->AmountAvailable;
        if ($security->ProductID == '1') {
          $buy_trade->UBABondYield = $upload->SellRate;
          // $sell_trade->Price = DB::select("exec procYieldToPrice '$security->SecurityRef', '$upload->SellRate' ")[0]->price;
        } else {
          $sell_trade->Price = $upload->SellRate;
        }
        // $sell_trade->Price = $upload->SellRate;
        $sell_trade->PriceMakerID = '2';
        $sell_trade->InputterID = auth()->id();
        if(empty($find_sell)) {
          $sell_trade->save();
        } else {
          $sell_trade->ModifiedDatetime = date('Y-m-d H:i:s.v');
          $sell_trade->ModifierID = auth()->id();
          $sell_trade->update();
        }
        
        // Store Prices in History Table
        $history = new PriceUploadHistory;
        $history->MaturityDate = $upload->MaturityDate;
        $history->SecurityID = $upload->SecurityID;
        $history->SecurityIdentifier = $upload->SecurityIdentifier;
        $history->TenorToMaturity = $upload->TenorToMaturity;
        $history->AmountAvailable = $upload->AmountAvailable;
        $history->BuyRate = $upload->BuyRate;
        $history->SellRate = $upload->SellRate;
        $history->InitiatorID = $upload->InitiatorID;
        $history->ConfirmerID = $upload->ConfirmerID;
        $history->ConfirmDate = $upload->ConfirmDate;
        $history->ApproverID = $upload->ApproverID;
        $history->ApprovedDate = $upload->ApprovedDate;
        $history->created_at = $upload->created_at;
        $history->updated_at = $upload->updated_at;
        $history->save();

        // Remove Inventories today if any, for this security
        $old_invs = Inventory::where('SecurityID', $security->SecurityRef)->whereDate('created_at', date('Y-m-d'));
        if(count($old_invs->get()) > 0)
          $old_invs->delete();

        // Store Inventory Buy
        $buy_inv = new Inventory;
        $buy_inv->SecurityID = $security->SecurityRef;
        $buy_inv->TransactionTypeID = '1';
        $buy_inv->Quantity = (int)$upload->AmountAvailable;
        $buy_inv->InputterID = $upload->InitiatorID;
        $buy_inv->ApproverID1 = auth()->id();
        $buy_inv->NotifyFlag = true;
        $buy_inv->ApprovedFlag = true;
        $buy_inv->ApprovalDate = $upload->ApprovedDate;
        // $buy_inv->TransactionTypeID2 = ?;
        $buy_inv->save();

        $buy_inv->ApproverID = '0';
        $buy_inv->update();

        // Store Inventory Sell
        $buy_inv = new Inventory;
        $buy_inv->SecurityID = $security->SecurityRef;
        $buy_inv->TransactionTypeID = '2';
        $buy_inv->Quantity = (int)$upload->AmountAvailable;
        $buy_inv->InputterID = $upload->InitiatorID;
        $buy_inv->ApproverID1 = auth()->id();
        $buy_inv->NotifyFlag = true;
        $buy_inv->ApprovedFlag = true;
        $buy_inv->ApprovalDate = $upload->ApprovedDate;
        // $buy_inv->TransactionTypeID2 = ?;
        $buy_inv->save();

        $buy_inv->ApproverID = '0';
        $buy_inv->update();


      }

      // ***========
      $footprint = (object) [
        'Title' => 'Approve Price Upload'
      ];
      FootPrint::logTrail($footprint);
      // ***========

      
      DB::commit();
      return $uploads;
    } catch (Exception $e) {
      DB::rollback();
      return $e;
    }
  }


  public function history()
  {
    // ***========
    $footprint = (object) [
      'Title' => 'Price Uplaod - History'
    ];
    FootPrint::logTrail($footprint);
    // ***========

    $prices = PriceUploadHistory::orderBy('PriceUploadRef', 'desc')->limit('50')->get();

    return view('price_upload.history', compact('prices'));
  }


}
