<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class MessageInbox extends Model
{
  protected $table   = 'tblMessages';
  protected $guarded = ['MessageRef'];
  public $primaryKey = 'MessageRef';

  public function sender()
  {
    return $this->belongsTo(User::class, 'FromID');
  }

  public function recipients()
  {
    return $this->belongsToMany(User::class, 'tblMessageRecipients', 'MessageID', 'UserID')->withPivot('IsRead', 'IsDeleted');
  }

  public function replies()
  {
      return $this->hasMany(MessageInbox::class, 'ParentID', 'MessageRef')->orderBy('created_at', 'desc');
  }

  public function files()
  {
      return $this->hasMany(MessageFile::class, 'MessageID');
  }

}
