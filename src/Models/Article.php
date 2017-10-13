<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table    = 'articles';
    public $timestamps  = true;
    protected $fillable = ['title', 'slug', 'tag', 'content', 'thumbnail'];    

    public function joinCategory()
    {
        $data = $this->join('categorys', 'categorys.id', '=', 'articles.category_id')
                    ->select('categorys.category', 'categorys.id as category_id','articles.*');
        return $data;
    }
}
