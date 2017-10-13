<?php

namespace App\Transformers;

use App\Models\Produk;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ProdukTransformer extends TransformerAbstract
{
    public function transform(Produk $produk)
    {
        return [
            'id'                   => $produk->id,
            'name'                 => $produk->name,
            'slug'                 => $produk->slug,
            'description'          => $produk->description,
            'image'                => $produk->image,
            'harga'                => $produk->harga,
            'stok'                 => $produk->stok
        ];
    }
}
