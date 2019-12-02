<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class MessageSubject extends Model
{
  protected $table   = 'tblMessageSubjects';
  protected $guarded = ['MessageSubjectRef'];
  public $primaryKey = 'MessageSubjectRef';
}
