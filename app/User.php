<?php

namespace TradefiUBA;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\HasActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use SoftDeletes {restore as restoreB;}
    use HasActivity;use Notifiable;
    use EntrustUserTrait {restore as restoreA;}
    protected $guarded = [
        'id', 'password_confirmation',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $logAttributes = ['username', 'email', 'avatar'];

    protected static $logOnlyDirty = true;
    function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }
    function swap()
    {
        $hash = bcrypt(auth()->user()->getKey() . microtime());

        \Session::put('userhash', $hash);

        $this->user_hash = $hash;
        $this->update();
    }

    function profile()
    {
        return $this->hasOne('TradefiUBA\Profile');
    }

    function cash()
    {
        return $this->hasOne('TradefiUBA\CashEntry', 'CustomerID');
    }

    function generatePin($length = 4)
    {
        $i   = 0;
        $pin = "";
        while ($i < $length) {
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }

    function gls()
    {
        return $this->hasMany('TradefiUBA\GL', 'CustomerID');
    }

    function abbreviation($string)
    {
        $splitted = explode(' ', $string);
        if (count($splitted) > 1) {
            return substr($splitted[0], 0, 1) . ' ' . substr($splitted[1], 0, 1);
        } else {
            return substr($splitted[0], 0, 1) . ' ' . substr($splitted[0], 1, 1);
        }
    }

    function activatedForTrading()
    {
        return $this->ActivatedFlag;
    }

    function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * Each User has many posts, through a Topic.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    function posts()
    {
        return $this->hasManyThrough(Post::class, Topic::class);
    }

    /**
     * Each User has many reports.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * A user has many messages (sent).
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * A user has many messages (received).
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    /**
     * Returns whether a user's avatar field is populated.
     *
     * @return boolean
     */

    function hasCustomAvatar()
    {
        if ($this->avatar !== null) {
            return true;
        }

        return false;
    }

    /**
     * Returns whether a user has a role of 'moderator'
     *
     * @return boolean
     */
    function isModerator()
    {
        return $this->role === 'moderator';
    }

    /**
     * Returns whether a user has a role of 'admin'
     *
     * @return boolean
     */
    function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Returns whether a user has a role of 'moderator' or 'admin'
     *
     * @return boolean
     */
    function isElevated()
    {
        return $this->role === 'moderator' || $this->role === 'admin';
    }

    /**
     * Returns a user's role
     *
     * @return string
     */
    function role()
    {
        return $this->role;
    }

    function site_role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Each User has many subscriptions.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Returns a Collection of subscriptions that a User has
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    function getUserSubscriptions()
    {
        return Subscription::where('user_id', $this->id)->get();
    }

    /**
     * Returns whether a user is subscribed to a Topic.
     *
     * @return mixed TradefiUBA\Subscription | boolean
     */
    function isSubscribedTo(Topic $topic)
    {
        // loop through all subscriptions for current user
        foreach ($this->getUserSubscriptions() as $subscription) {
            if ($subscription->topic_id === $topic->id) {
                // has a certain subscription, let's return it
                return $subscription;
            }
        }

        // no subscriptions at all..
        return null;
    }

    /**
     * Returns whether a User is the recipient of a Message.
     *
     * @param  TradefiUBA\Message $user
     * @return boolean
     */
    function isRecipient(Message $message)
    {
        return $this->id === $message->recipient_id;
    }

    /**
     * Returns whether the current User has any unread messages.
     *
     * @return boolean
     */
    function hasUnreadMessages()
    {
        return count(Message::where('recipient_id', $this->id)->where('read', 0)->get()) > 0;
    }

    /**
     * Returns whether the current User has any unread messages from a specific sender.
     *
     * @return boolean
     */
    function hasUnreadMessagesFromSender(User $user)
    {
        return count(Message::where('recipient_id', $this->id)->where('sender_id', $user->id)->where('read', 0)->get()) > 0;
    }

    /**
     * Returns a Collection of messages received by the current User, from a specific sender.
     *
     * @return Illuminate\Support\Collection
     */
    function receivedMessagesFromSender(User $user)
    {
        return Message::where('recipient_id', $this->id)->where('sender_id', $user->id)->where('read', 0)->get();
    }

    /**
     * Returns the count of unread messages for the current User.
     *
     * @return int
     */
    function unreadMessageCount()
    {
        return count(Message::where('recipient_id', $this->id)->where('read', 0)->get());
    }

    /**
     * Returns the count of unread messages for the current User, given a specific sender.
     *
     * @return int
     */
    function unreadMessageCountForSender(User $user)
    {
        return count(Message::where('recipient_id', $this->id)->where('sender_id', $user->id)->where('read', 0)->get());
    }

    // roles function as defined by TradeFI's Team
    function tradefi_admin()
    {
        return auth()->user()->admin && auth()->user()->site_role == 'Admin';
    }

    function tradefi_admin_authorizer()
    {
        return auth()->user()->admin && auth()->user()->site_role == 'Admin Authorizer';
    }

    function tradefi_super_admin()
    {
        return auth()->user()->admin && auth()->user()->site_role == 'Super Admin';
    }

    function tradefi_authorizer()
    {
        return auth()->user()->admin && auth()->user()->site_role == 'Authorizer';
    }

    function tradefi_ops_initiator()
    {
        return auth()->user()->admin && auth()->user()->site_role == 'Ops Initiator';
    }

    function tradefi_ops_authorizer()
    {
        return auth()->user()->admin && auth()->user()->site_role == 'Ops Authorizer';
    }

    public function inbox()
    {
        return $this->belongsToMany(MessageInbox::class, 'tblMessageRecipients', 'UserID', 'MessageID')->orderBy('MessageRef', 'desc')->with('sender')->withPivot('IsRead', 'IsDeleted');
    }
    public function unread_messages()
    {
        return $this->belongsToMany(MessageInbox::class, 'tblMessageRecipients', 'UserID', 'MessageID')->orderBy('MessageRef', 'desc')->with('sender')->withPivot('IsRead', 'IsDeleted')->wherePivot('IsRead', false);
    }
    public function sent_messages()
    {
        return $this->hasMany(MessageInbox::class, 'FromID')->orderBy('MessageRef', 'desc');
    }
    public function unread_inbox()
    {
        return $this->hasMany(MessageRecipient::class, 'UserID')->where('IsRead', false);
    }

    public function getFullNameAttribute()
    {
      return $this->username;
    }

    public function avatar()
    {
        return $this->avatar ?? 'default.png';
    }
    public function avatar_light()
    {
        return $this->avatar ?? 'default2.png';
    }
    public function avatar_url()
    {
        return url('/') . '/images/avatars/' . ($this->avatar ?? 'default.png');
    }

    public function company()
    {
      return $this->belongsTo(Company::class, 'company_id');
    }

    // public function inCompany($company)
    // {
    //     foreach ($this->roles as $role) {
    //         $companies[] = $role->company->name;
    //     }
    //     return array_intersect((array) $company, $companies);
    // }

    public function hasMenu($id)
    {
      $menu = Menu::where('id', $id)->whereHas('roles', function($q) {
        $q->whereIn('id', $this->roles->pluck('id')->toArray());
      })->first();
      return !empty($menu);
    }

}
