<?php

namespace TradefiUBA\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class Profile extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'user_id'            => $this->user_id,
            'firstname'          => $this->firstname,
            'lastname'           => $this->lastname,
            'fullname'           => $this->fullname,
            'username'           => $this->user->username,
            'avatar'             => !is_null(auth()->user()->avatar) ? env('app_url') . '/storage/avatar/' . $this->user->avatar : env('app_url') . '/images/avatar.png',
            'address'            => $this->address,
            'gender'             => $this->gender,
            'dob'                => $this->dob,
            'email'              => $this->user->email,
            'phone'              => $this->phone,
            'kin_address'        => $this->kin_address,
            'kin_fullname'       => $this->kin_fullname,
            'kin_relationship'   => $this->kin_relationship,
            'kin_phone'          => $this->kin_phone,
            'is_activated'       => (boolean) $this->user->ActivatedFlag,
            'changed_pin'        => (boolean) $this->user->changed_pin,
            'trading_experience' => $this->trading_experience,
            'income_bracket'     => $this->income_bracket,
            'bvn'                => $this->user->profile->bank_detail->first()->bvn,
            'book_balance'       => (float) $this->user->gls->where('AccountTypeID', 1)->first()->BookBalance,
            'cleared_balance'    => (float) $this->user->gls->where('AccountTypeID', 1)->first()->ClearedBalance,
            'bank'               => $this->user->profile->bank_detail->first()->bank,
        ];
    }
}
