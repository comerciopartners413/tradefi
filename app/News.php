<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'body'];
    protected $table    = 'news';

    public function getRouteKeyName()
    {
        return 'title';
    }
}
