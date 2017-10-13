<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
use App\Models\User;


class UserProduk extends Model
{
    protected $table    = 'user_produk';
    protected $primarykey = 'id';
    public $timestamps  = true;
    protected $fillable = ['user_id', 'produk_id', 'kuantitas', 'total_harga'];

    public function joinUser()
    {
        $data = $this->join('users', 'users.id', '=', 'user_produk.user_id')
                    ->select('users.username');
        return $data;
    }
}
