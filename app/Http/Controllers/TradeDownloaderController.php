<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Config;
use TradefiUBA\TradeData;
use TradefiUBA\User;
use Excel;
use Illuminate\Http\Request;
use DB;
class TradeDownloaderController extends Controller
{
    public function post(Request $request)
    {

    }

    public function get_trades()
    {
        $tradelist = collect(\DB::select("
        EXEC procHistoricTradeDownloader '2018-01-01', '9000-01-01'
        "));

        $tradelist_comercio = collect(\DB::select("
        EXEC procTradeDownloaderStanbic
        "));
        // dd($tradelist_comercio);
        return view('reports.trade_downloader', compact('tradelist', 'tradelist_comercio'));
    }

    public function downloadExcel(Request $request, $type)
    {
        $data_x = \DB::select("
        EXEC procTradeDownloader
        ");

        foreach ($data_x as $d) {
            $data2[] = (array) $d;
        }

        if (count($data_x) <= 0) {
            return redirect('/download-trades')->with('error', 'No Trade has been done today');
        }
        // TODO: change naming convention
        $data = json_decode(json_encode($data2), true);
        $ex   = Excel::create(str_replace('-', '', 'TradeFI' . Config::first()->TradeDate), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);

    }

    public function downloadExcel2(Request $request, $type, $date)
    {
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);
        $formatted_date = date_format(date_create($date), 'Y-m-d');
        $data_x         = \DB::select("
        EXEC procTradeDownloaderForDate '$formatted_date'
        ");

        foreach ($data_x as $d) {
            $data2[] = (array) $d;
        }

        if (count($data_x) <= 0) {
            return redirect('/download-trades')->with('error', 'No Trade has been done today');
        }
        // TODO: change naming convention
        $data = json_decode(json_encode($data2), true);
        $ex   = Excel::create(str_replace('-', '', 'TradeFI' . $formatted_date), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);

    }

    public function downloadExcelComercio(Request $request, $type)
    {
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);
        $data_x = \DB::select("
        EXEC procTradeDownloaderStanbic
        ");

        foreach ($data_x as $d) {
            $data2[] = (array) $d;
        }

        if (count($data_x) <= 0) {
            return redirect('/download-trades')->with('error', 'No Trade has been done today');
        }
        // TODO: change naming convention
        $data = json_decode(json_encode($data2), true);
        $ex   = Excel::create(str_replace('-', '', 'TradeFIComercio' . Config::first()->TradeDate), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);

    }

    public function downloadExcelComercio2(Request $request, $type, $date)
    {
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);
        $formatted_date = date_format(date_create($date), 'Y-m-d');
        $data_x         = \DB::select("
        EXEC procTradeDownloaderForDateStanbic '$formatted_date'
        ");

        foreach ($data_x as $d) {
            $data2[] = (array) $d;
        }

        if (count($data_x) <= 0) {
            return redirect('/download-trades')->with('error', 'No Trade has been done today');
        }
        // TODO: change naming convention
        $data = json_decode(json_encode($data2), true);
        $ex   = Excel::create(str_replace('-', '', 'TradeFIComercio' . $formatted_date), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);

    }

    public function spreadincome()
    {
        $tradedata = TradeData::select('TradeDate', 'SettlementDate', 'SecurityID', 'InputterID', 'SettlementAmount', 'Spread', 'ProductID1', 'TransactionTypeID', 'MaturityDate1', 'Quantity')->get();
        // dd($tradedata);
        return view('reports.spread_income', compact('tradedata'));
    }

    
    public function download_settlement(Request $request, $format, $date)
    {
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);

        // DATEDIFF(day, tblSecurity.IssueDate, tblSecurity.MaturityDate) as 'Days to Maturity'
        
        // Instructed to use inverse of BUY/SELL (Transaction)

        $formatted_date = date_format(date_create($date), 'Y-m-d');
        $data_x         = \DB::select("
          EXEC procUBATradeDownloader '$formatted_date'
        ");
        // $data_x         = TradeData::select(DB::raw("'FT GENERATED' as Response, 'CPAM TradeFI Client Accounts' as CounterParty, CASE WHEN tblTradeData.TransactionTypeID = 1 THEN 'SELL' ELSE 'BUY' END as 'BUY/SELL', tblSecurity.SecuritiesIdentifier as Security, DATEDIFF(day, tblSecurity.SettlementDate, tblTradeData.MaturityDate) as 'Days to Maturity', CONVERT(DECIMAL(10,2), tblTradeData.DiscountRate) as 'Yield', CONVERT(varchar, CAST(tblTradeData.Quantity AS money), 1) as 'Original Face', convert(varchar, TradeDate, 6) as 'Deal Date', convert(varchar, SettlementDate, 6) as 'Settlement Date', 'TRADE' as 'Investment Status', 'C_HFT' as SUBTYPE, '/BANK/SALES/CUST_TBILLS' as TRADING_BOOK, 'SALES' as DEPT_NAME, 'SEC_LOT' as 'SI_FLOW_PAY.NOSTRO', 'SWIFT' as 'SI_FLOW_PAY.SETT_METHOD', 'SEC_LOT' as 'SI_FLOW_REC.NOSTRO', 'SWIFT' as 'SI_FLOW_REC.SETT_METHOD', 'DEF_COC' as COST_OF_CARRY_REF_RATE_CODE, '//' as MEMO_FIELD_0
        // "))
        // ->join('tblSecurity', 'tblTradeData.SecurityID', '=', 'tblSecurity.SecurityRef')
        // ->whereDate('tblTradeData.TradeDate', $date)
        // ->groupBy('Security', 'TransactionTypeID')
        // ->get();
        // dd($data_x->toArray());

        // foreach ($data_x as $d) {
        //     $data2[] = (array) $d;
        // }

        if (count($data_x) <= 0) {
            return redirect()->back()->with('error', 'No Trade has been done today');
        }
        // TODO: change naming convention
        $data = json_decode(json_encode($data_x), true);
        $ex   = Excel::create(str_replace('-', '', 'TradeFI' . $formatted_date), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($format);

    }


    
    public function download_gis(Request $request, $type, $date)
    {
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);
        $formatted_date = date_format(date_create($date), 'Y-m-d');
        $data_x         = \DB::select("
        EXEC procUBATradeDownloaderGIS '$formatted_date'
        ");

        foreach ($data_x as $d) {
            $data2[] = (array) $d;
        }

        if (count($data_x) <= 0) {
            return redirect('/reports/settlement_gis')->with('error', 'No confirmed trades today');
        }
        // TODO: change naming convention
        $data = json_decode(json_encode($data2), true);
        $ex   = Excel::create(str_replace('-', '', 'TradeFI_GIS' . $formatted_date), function ($excel) use ($data) {
            $excel->sheet('TradeFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
                $sheet->setColumnFormat(array(
                  'E2:E500' => '0.00',
                  'H2:H500' => 'dd/mm/yy'
                ));
            });
        })->download($type);

    }
}
