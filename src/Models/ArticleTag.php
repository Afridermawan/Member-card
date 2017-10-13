<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    protected $table    = 'article_tags';
    public $timestamps  = false;
    protected $fillable = ['article_id','tag_id'];
}
