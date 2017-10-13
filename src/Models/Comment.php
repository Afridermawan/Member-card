<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Comment extends Model
{
    protected $table = 'comments';
    protected $primarykey = 'id';
    protected $fillable = ['article_id', 'user_id', 'comment'];
    public $timestamps = true;

}
