<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class PriceUpload extends Model
{
  protected $table      = 'tblPriceUpload';
  protected $guarded    = ['PriceUploadRef'];
  protected $primaryKey = 'PriceUploadRef';

  public function initiator()
  {
    return $this->belongsTo(User::class, 'InitiatorID');
  }
}
