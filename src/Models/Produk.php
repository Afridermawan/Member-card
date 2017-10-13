<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table    = 'produks';
    protected $primarykey = 'id';
    public $timestamps  = true;
    protected $fillable = ['name', 'slug', 'description', 'image', 'harga', 'stok'];
}
