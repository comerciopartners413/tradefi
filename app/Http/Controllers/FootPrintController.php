<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\FootPrint;
use Illuminate\Http\Request;

class FootPrintController extends Controller
{
    /*
    |-----------------------------------------
    | AUTHENTICATE
    |-----------------------------------------
     */
    public function __construct()
    {
        // body
        $this->middleware('auth')->except(['store']);
    }

    /*
    |-----------------------------------------
    | SHOW FOOTPRINT VIEW INDEX
    |-----------------------------------------
     */
    public function index(Request $request)
    {
        // body

        // custom event name
        // $request->Description = "Activity Logs";
        // FootPrint::logTrail($request);

        $footprints = FootPrint::where('EventBy', '!=', '1')->orderBy('EventRef', 'desc')->limit('100')->get();

        return view('audit_trails.index', compact('footprints'));
    }

    /*
    |-----------------------------------------
    | CREATE or STORE DATA
    |-----------------------------------------
     */
    public function store(Request $request)
    {
        // body
        $log_print = new FootPrint();
        $data      = $log_print->addNew();

        // return response.
        return response()->json($data);
    }

    /*
    |-----------------------------------------
    | SHOW DATA
    |-----------------------------------------
     */
    public function getAll()
    {
        // body
        $audit_trails = new FootPrint();
        $data         = $audit_trails->getAllEvent();

        // return response.
        return datatables()->collection(collect($data))->toJson();
        // return response()->json($data);
    }

    /*
    |-----------------------------------------
    | SHOW AUDIT BY USER
    |-----------------------------------------
     */
    public function getByUserId(Request $request, $actor_id)
    {
        // body
        $audit_trails = new FootPrint();
        $data         = $audit_trails->getEventByActor($actor_id);

        // return response.
        return response()->json($data);
    }

    /*
    |-----------------------------------------
    | LOG TRAIL
    |-----------------------------------------
     */
    public function log($payload)
    {
        // body
        FootPrint::logTrail($payload);
    }
}
