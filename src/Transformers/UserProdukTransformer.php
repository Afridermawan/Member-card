<?php

namespace App\Transformers;

use App\Models\UserProduk;
use App\Models\Produk;
use App\Models\User;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class UserProdukTransformer extends TransformerAbstract
{
    public function transform(UserProduk $userProduk)
    {
        $user = User::find($userProduk->user_id);

        $produk = Produk::find($userProduk->produk_id);

        return [
            'id'             => $userProduk->id,
            'username'       => $user->username,
            'image'          => $produk->image,
            'name'           => $produk->name,
            'harga'          => $produk->harga,
            'kuantitas'      => $userProduk->kuantitas,
            'total_harga'    => $userProduk->total_harga
        ];
    }
}
