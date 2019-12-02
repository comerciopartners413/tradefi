<?php

namespace TradefiUBA\Http\Controllers;

use DB, Event;
use TradefiUBA\Security;
use TradefiUBA\Inventory;
use TradefiUBA\TradeData;
use TradefiUBA\Events\InventoryAddedEvent;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{

    public function __construct()
    {
        // $this->middleware('role:Cavidel Admin|Admin|partner');
    }
    public function checklist()
    {
        // this page is intended to show all data needed to be approved per module
        $approver_role = auth()->user()->roles->pluck('id');
        // dd($approver_role);

        // load modules
        $securities = Security::where('ApproverID', '<>', 0)
            ->where('NotifyFlag', 1)
            ->whereIn('ApproverID', $approver_role)->get();

        $inventory = Inventory::where('ApproverID', '<>', 0)
            ->where('NotifyFlag', 1)
            ->whereIn('ApproverID', $approver_role)->get();
        // dd($securities);
        return view('approvals.approvallist', compact('approver_role', 'securities', 'inventory'));
    }

    public function checklist_inventory()
    {
        // this page is intended to show all data needed to be approved per module
        $approver_role = auth()->user()->roles->pluck('id');
        // dd($approver_role);

        $inventory = Inventory::where('ApproverID', '<>', 0)
            ->where('NotifyFlag', 1)
            ->whereIn('ApproverID', $approver_role)->get();
        // dd($securities);
        return view('approvals.approvallist_inventory', compact('approver_role', 'inventory'));
    }

    public function post_checklist(Request $request)
    {
        return dd($request);
    }

    public function approve(Request $request)
    {
        $ApprovedDate = $request->ApprovedDate;
        $SelectedID   = collect($request->SelectedID);
        $ApproverID   = $request->ApproverID;
        $Comment      = $request->Comment;
        $ModuleID     = $request->ModuleID;
        $ApprovedFlag = $request->ApprovedFlag;
        // $new_array    = array();
        foreach ($SelectedID as $value) {
            // array_push($new_array, intval($value));
            $approve_proc = \DB::statement(
                "EXEC procApproveRequest  '$ApprovedDate', '$value', $ModuleID, '$Comment', $ApproverID, $ApprovedFlag"
            );
            // fire event if approval is completed
            if ($ModuleID == 4) {
                $inventory = Inventory::find($value);
                if ($inventory->ModuleID == 4 && $inventory->ApproverID == 0 && $inventory->ApprovedFlag == 1) {
                    Event::fire(new InventoryAddedEvent());
                }
            }
        }
        // $new_array2   = (implode(',', $new_array));

        return response()->json([
            'message' => 'Approved successfully',
        ])->setStatusCode(200, 'OK');
    }

    public function reject(Request $request)
    {
        $RejectedDate = $request->RejectedDate;
        $SelectedID   = collect($request->SelectedID);
        $RejecterID   = $request->RejecterID;
        $Comment      = $request->Comment;
        $ModuleID     = $request->ModuleID;
        $RejectedFlag = $request->RejectedFlag;
        $new_array    = array();
        foreach ($SelectedID as $value) {
            array_push($new_array, intval($value));
        }
        $new_array2 = (implode(',', $new_array));

        $approve_proc = \DB::statement(
            "EXEC procRejectRequest  '$RejectedDate', '$new_array2', $ModuleID, '$Comment', $RejecterID, $RejectedFlag"
        );
        return response()->json([
            'message' => 'Rejected successfully',
        ]);
    }

    public function confirm_trades(Request $request)
    {
      foreach ($request->refs as $ref) {
        $trade = TradeData::find($ref);
        $trade->ApprovedFlag = true;
        $trade->ApproverID = auth()->id();
        $trade->ApprovalDate = date('Y-m-d H:i:s');
        $trade->update();
      }
      return $trade;

    }

}
