<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    protected $table    = 'user_event';
    public $timestamps  = true;
    protected $fillable = ['user_id', 'event_id', 'kuantitas', 'total_harga'];
}
