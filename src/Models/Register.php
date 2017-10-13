<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Register extends Model
{
    protected $table = 'registers';
    protected $primarykey = 'id';
    protected $fillable = ['user_id', 'token', 'expired_date'];
    public $timestamps = false;
}


 ?>
