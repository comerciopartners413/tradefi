<?php

namespace TradefiUBA;

use TradefiUBA\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class FootPrint extends Model
{
    protected $table      = "tblFootPrintEvent";
    protected $guarded    = "EventRef";
    protected $primaryKey = "EventRef";
    public $timestamp     = true;

    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    /*
    |-----------------------------------------
    | ADD TO FOOTPRINT
    |-----------------------------------------
     */
    public function addNew($payload)
    {
        // body
        $add_new               = new FootPrint();
        $add_new->EventBy      = $payload->EventBy ?? auth()->ser()->id;
        $add_new->EventPage    = $payload->EventPage;
        $add_new->EventDetails = $payload->EventDetails;
        $add_new->EventAvatar  = $payload->EventAvatar;
        $add_new->EventLevel   = $payload->EventLevel;
        $add_new->EventIp      = $payload->EventIp;
        $add_new->EventBrowser = $payload->EventBrowser;
        $add_new->save();
    }

    /*
    |-----------------------------------------
    | ADD TO FOOTPRINT ON STATIC
    |-----------------------------------------
     */
    public static function logTrail($payload)
    {
        // get route information
        // $payload->EventPage = $payload->route()->getName() ?? $payload->path();
        // current page as route name

        // get menu name || use custom menu name when menu description does not exist
        $payload->EventPage    = $payload->Title;
        $payload->EventDetails = $payload->Details ?? $payload->Title;

        // body
        $add_new               = new FootPrint();
        $add_new->EventBy      = $payload->EventBy ?? auth()->user()->id;
        $add_new->EventPage    = $payload->EventPage ?? '';
        $add_new->EventDetails = $payload->EventDetails ?? '';
        $add_new->EventAvatar  = $payload->EventAvatar ?? '';
        $add_new->EventLevel   = $payload->EventLevel ?? '';
        $add_new->EventIp      = $_SERVER['REMOTE_ADDR'];
        $add_new->EventBrowser = request()->header('User-Agent');
        $add_new->save();
    }

    /*
    |-----------------------------------------
    | FETCH EVENT
    |-----------------------------------------
     */
    public function getAllEvent()
    {
        // body
        $all_trails = FootPrint::orderBy("created_at", "DESC")->get();
        $audit_box  = [];
        foreach ($all_trails as $key => $value) {
            $user                = User::where("id", $value->EventBy)->first();
            $value->EventByID    = $user->id;
            $value->EventBy      = $user->profile->fullname;
            $value->EventEmail   = $user->email;
            $value->EventBrowser = $this->resolvePlatform($value->EventBrowser);
            array_push($audit_box, $value);
        }

        return $audit_box;
    }

    /*
    |-----------------------------------------
    | FETCH EVENT
    |-----------------------------------------
     */
    public function getEventByActor($actor_id)
    {
        // body
        $all_trails = FootPrint::where('EventBy', $actor_id)->orderBy("created_at", "DESC")->limit('100')->get();
        $audit_box  = [];
        foreach ($all_trails as $key => $value) {
            $user                = User::where("id", $value->EventBy)->first();
            $value->EventBy      = $user->name;
            $value->EventEmail   = $user->email;
            $value->EventBrowser = $this->resolvePlatform($value->EventBrowser);
            array_push($audit_box, $value);
        }

        return $audit_box;
    }

    /*
    |-----------------------------------------
    | GET PLATFORM
    |-----------------------------------------
     */
    public function resolvePlatform($user_agent)
    {
        // Get Platform
        if (preg_match('/windows|win64/i', $user_agent)) {
            $data = "Windows X64";
        } elseif (preg_match('/windows|win32/i', $user_agent)) {
            $data = "Windows X32";
        } elseif (preg_match('/linux/i', $user_agent)) {
            $data = "Linux";
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $data = "Apple Macintosh";
        } elseif (preg_match('/CrOS/i', $user_agent)) {
            $data = "Chromebook CrOS";
        } elseif (preg_match('/windows phone/i', $user_agent)) {
            $data = "Window Mobile Device";
        } elseif (preg_match('/android/i', $user_agent)) {
            $data = "Android Device";
        } elseif (preg_match('/iPad|iPhone|iPod/i', $user_agent)) {
            $data = "Apple Mobile Device";
        } else {
            $data = "---";
        }

        // resolve and attach browser information
        $browser = $this->resolveBrowser($user_agent);

        // return
        return $data . ' ' . $browser;
    }

    /*
    |-----------------------------------------
    | GET AGENT
    |-----------------------------------------
     */
    public function resolveBrowser($user_agent)
    {
        if (preg_match('/OPR/i', $user_agent)) {
            $data = "Opera Browser";
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $data = "Chrome Browser";
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $data = "Mozilla Firefox Browser";
        } elseif (preg_match('/Edge/i', $user_agent)) {
            $data = "Microsoft Edge Browser";
        } elseif (preg_match('/Trident/i', $user_agent)) {
            $data = "Internet Explorer";
        } elseif (preg_match('/MSIE/i', $user_agent)) {
            $data = "Internet Explorer";
        } else {
            $data = "---";
        }

        // return
        return $data;
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'EventBy');
    }
}
