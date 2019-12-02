<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class PriceUploadHistory extends Model
{
  protected $table      = 'tblPriceUploadHistory';
  protected $guarded    = ['PriceUploadRef'];
  protected $primaryKey = 'PriceUploadRef';

  public $dates = ['ApprovedDate'];

  public function initiator()
  {
    return $this->belongsTo(User::class, 'InitiatorID');
  }

  public function approver()
  {
    return $this->belongsTo(User::class, 'ApproverID');
  }
}
