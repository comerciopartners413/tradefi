<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;
use TradefiUBA\TradeData;
use PDF;
use DB;
use Excel;

class InstructionLetterController extends Controller
{
	public function aggregate()
	{	
			// $trades = TradeData::all();
			$trade_dates = TradeData::select('TradeDate')->groupBy('TradeDate')->get();
			return view('instructions.aggregate', compact('trades', 'trade_dates'));
	}

	public function download_aggregates($pdf, $date)
	{
    try {
      $date = (empty($date))? date('Y-m-d') : $date;
      // $date = '2018-07-10';
      
      // $pdf = PDF::loadView('pdf.investments.new', compact('inv', 'letter'));
      if ($pdf == 'tbs_buy') {
        $trades = TradeData::select(DB::raw('SecurityID, MAX(TradeDate) as TradeDate, MAX(tblTradeData.SettlementDate) as SettlementDate, MAX(MaturityDate) as MaturityDate, MAX(IssueDate) as IssueDate, MAx(Tenor) as Tenor, wct.WAVG(Quantity, Yield) as Yield, wct.WAVG(Quantity, DiscountRate) as DiscountRate, SUM(Quantity) as FaceValue, SUM(DiscountAmount) as DiscountAmount'))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->where('tblSecurity.ProductID', '2')
          ->where('TransactionTypeID', '1')
          ->whereDate('TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          ->groupBy('SecurityID')
          ->with('security')
          ->get();
        $pdf = PDF::loadView('instructions.letters.tbs_buy', compact('trades', 'date'));
        return $pdf->download('TBills Purchase '. $date .''. (($date == date('Y-m-d'))? ' - '.date('H_iA') : '').'.pdf');
  
      } elseif($pdf == 'tbs_sell') {
        $trades = TradeData::select(DB::raw('SecurityID, MAX(TradeDate) as TradeDate, MAX(tblTradeData.SettlementDate) as SettlementDate, MAX(MaturityDate) as MaturityDate, MAX(IssueDate) as IssueDate, MAx(Tenor) as Tenor, wct.WAVG(Quantity, Yield) as Yield, wct.WAVG(Quantity, DiscountRate) as DiscountRate, SUM(Quantity) as FaceValue, SUM(DiscountAmount) as DiscountAmount'))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->where('tblSecurity.ProductID', '2')
          ->where('TransactionTypeID', '2')
          ->whereDate('TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          ->groupBy('SecurityID')
          ->with('security')
          ->get();
        $pdf = PDF::loadView('instructions.letters.tbs_sell', compact('trades', 'date'));
        return $pdf->download('TBills Sale '. $date .''. (($date == date('Y-m-d'))? ' - '.date('H_iA') : '').'.pdf');
  
      } elseif($pdf == 'bonds_buy') {
        $trades = TradeData::select(DB::raw('SecurityID, MAX(TradeDate) as TradeDate, MAX(tblTradeData.SettlementDate) as SettlementDate, MAX(MaturityDate) as MaturityDate, MAX(IssueDate) as IssueDate, MAx(Tenor) as Tenor, wct.WAVG(Quantity, Yield) as Yield, wct.WAVG(Quantity, DiscountRate) as DiscountRate, SUM(Quantity) as FaceValue, SUM(DiscountAmount) as DiscountAmount'))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->where('tblSecurity.ProductID', '1')
          ->where('TransactionTypeID', '1')
          ->whereDate('TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          ->groupBy('SecurityID')
          ->with('security')
          ->get();
        $pdf = PDF::loadView('instructions.letters.bonds_buy', compact('trades', 'date'));
        return $pdf->download('FGNBonds Purchase '. $date .''. (($date == date('Y-m-d'))? ' - '.date('H_iA') : '').'.pdf');
  
      } elseif($pdf == 'bonds_sell') {
        $trades = TradeData::select(DB::raw('SecurityID, MAX(TradeDate) as TradeDate, MAX(tblTradeData.SettlementDate) as SettlementDate, MAX(MaturityDate) as MaturityDate, MAX(IssueDate) as IssueDate, MAx(Tenor) as Tenor, wct.WAVG(Quantity, Yield) as Yield, wct.WAVG(Quantity, DiscountRate) as DiscountRate, SUM(Quantity) as FaceValue, SUM(DiscountAmount) as DiscountAmount'))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->where('tblSecurity.ProductID', '1')
          ->where('TransactionTypeID', '2')
          ->whereDate('TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          ->groupBy('SecurityID')
          ->with('security')
          ->get();
        $pdf = PDF::loadView('instructions.letters.bonds_sell', compact('trades', 'date'));
        return $pdf->download('FGNBonds Sale '. $date .''. (($date == date('Y-m-d'))? ' - '.date('H_iA') : '').'.pdf');
        
      } elseif($pdf == 'fop') {
        $trades_buy = TradeData::select(DB::raw("SecurityID, securities_account, ('CPAM TRADEFI / ' + profiles.firstname + ' ' + profiles.lastname) AS Beneficiary, TradeDate, SettlementDate, MaturityDate, IssueDate, Tenor, Yield, Quantity as FaceValue, DiscountAmount, tblSecurity.ProductID"))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->join('profiles', 'tblTradeData.InputterID', '=', 'profiles.user_id')
          ->join('users', 'tblTradeData.InputterID', '=', 'users.id')
          ->whereIn('tblSecurity.ProductID', [1, 2])
          ->where('TransactionTypeID', '1')
          ->whereDate('tblTradeData.TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          // ->groupBy('SecurityID')
          ->with('security')
          ->get();
  
        $trades_sell = TradeData::select(DB::raw("SecurityID, securities_account, ('CPAM TRADEFI / ' + profiles.firstname + ' ' + profiles.lastname) AS Beneficiary, TradeDate, SettlementDate, MaturityDate, IssueDate, Tenor, Yield, Quantity as FaceValue, DiscountAmount, tblSecurity.ProductID"))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->join('profiles', 'tblTradeData.InputterID', '=', 'profiles.user_id')
          ->join('users', 'tblTradeData.InputterID', '=', 'users.id')        
          ->whereIn('tblSecurity.ProductID', [1, 2])
          ->where('TransactionTypeID', '2')
          ->whereDate('tblTradeData.TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          // ->groupBy('SecurityID')
          ->with('security')
          ->get();
          // dd($trades);
        $pdf = PDF::loadView('instructions.letters.fop', compact('trades_buy', 'trades_sell', 'date'));
        return $pdf->download('FOP Instruction TradeFi '. $date .''. (($date == date('Y-m-d'))? ' - '.date('H_iA') : '').'.pdf');
      }
    
        elseif($pdf == 'fop_excel') {
        $trades = TradeData::select(DB::raw("ROW_NUMBER() Over (Order by TradeDate) As 'S.N', ('CPAM TRADEFI / ' + profiles.firstname + ' ' + profiles.lastname) AS 'BENEFICIARY NAME', securities_account AS 'BENEFICIARY ACCOUNT NUMBER', SettlementDate AS 'SETTLEMENT DATE', MaturityDate AS 'MATURITY DATE', Quantity as 'FACE VALUE' "))
          ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
          ->join('profiles', 'tblTradeData.InputterID', '=', 'profiles.user_id')
          ->join('users', 'tblTradeData.InputterID', '=', 'users.id')
          ->whereIn('tblSecurity.ProductID', [1, 2])
          // ->where('TransactionTypeID', '1')
          ->whereDate('tblTradeData.TradeDate', $date)
          ->where('tblTradeData.ApprovedFlag', true)
          // ->groupBy('SecurityID')
          // ->with('security')
          ->get();
  
        // $trades_sell = TradeData::select(DB::raw("SecurityID, securities_account, ('CPAM TRADEFI / ' + profiles.firstname + ' ' + profiles.lastname) AS Beneficiary, TradeDate, SettlementDate, MaturityDate, IssueDate, Tenor, Yield, Quantity as FaceValue, DiscountAmount, tblSecurity.ProductID"))
        //   ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
        //   ->join('profiles', 'tblTradeData.InputterID', '=', 'profiles.user_id')
        //   ->join('users', 'tblTradeData.InputterID', '=', 'users.id')        
        //   ->whereIn('tblSecurity.ProductID', [1, 2])
        //   ->where('TransactionTypeID', '2')
        //   ->whereDate('tblTradeData.TradeDate', $date)
        //   // ->groupBy('SecurityID')
        //   ->with('security')
        //   ->get();
  
          // dd($trades);
        // $pdf = PDF::loadView('instructions.letters.fop', compact('trades_buy', 'trades_sell', 'date'));
        // return $pdf->download('FOP Instruction TradeFi '. $date .''. (($date == date('Y-m-d'))? ' - '.date('H_iA') : '').'.pdf');
  
        $data = json_decode(json_encode($trades), true);
        $ex   = Excel::create(str_replace('-', '_', 'FOP Instruction TradeFi ' . $date), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
                $sheet->prependRow(array(
                  'FOP FOR TBILLS AND BONDS'
                ));
                $sheet->mergeCells('A1:F1');
                // $sheet->row(1, function($row) {
                //   // call cell manipulation methods
                //   $row->setFontBold(true);
                // });
                $sheet->cells('A1:F1', function($cells) {
                  $cells->setFontWeight('bold');
                  $cells->setBackground('#e6b8b7');
                  $cells->setAlignment('center');
                });
                $sheet->cells('A2:F2', function($cells) {
                  $cells->setFontWeight('bold');
                });
                $sheet->setColumnFormat(array(
                  // 'B' => '0',
                  // 'D' => '0.00',
                  'F3:F100' => '#,##0.00',
                  // 'F' => 'yyyy-mm-dd',
                ));
  
            });
        })->download('xlsx');
      }

    } catch (\Exception $e) {
      return redirect()->with('error', 'File could not be downloaded, please try again.');
    }

		
  }
  

}
