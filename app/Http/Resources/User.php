<?php

namespace TradefiUBA\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"                      => $this->id,
            "username"                => $this->username,
            "email"                   => $this->email,
            "changed_pin"             => (boolean) $this->changed_pin,
            "confirmed"               => (boolean) $this->confirmed,
            "confirmation_code"       => $this->confirmation_code,
            "is_admin"                => (boolean) $this->admin,
            "activated_flag"          => $this->ActivatedFlag,
            "last_activity"           => (string) $this->last_activity,
            "avatar"                  => $this->avatar,
            "identification"          => $this->identification,
            "utility_bill"            => $this->utility_bill,
            "moi"                     => $this->moi,
            "cash_account"            => $this->cash_account,
            "securities_account"      => $this->securities_account,
            "kyc_flag"                => (boolean) $this->kyc_flag,
            "securities_account_flag" => (boolean) $this->securities_account_flag,
            "cash_account_flag"       => (boolean) $this->cash_account_flag,
            "created_at"              => (string) $this->created_at,
            "updated_at"              => (string) $this->updated_at,
            "deleted_at"              => (string) $this->deleted_at,
        ];
    }
}
