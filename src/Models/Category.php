<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table    = 'categorys';
    public $timestamps = false;
    protected $fillable = ['category'];

    public function joinArtikel()
    {
        $data = $this->join('articles', 'articles.category_id', '=', 'categorys.id')
                    ->select('categorys.category', 'categorys.id as id_category','articles.*');
        return $data;
    }
}
