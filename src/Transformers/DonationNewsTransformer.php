<?php

namespace App\Transformers;

use App\Models\DonationNews;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class DonationNewsTransformer extends TransformerAbstract
{
    public function transform(DonationNews $donationNews)
    {
        return [
            'id'            => $donationNews->id,
            'title'         => $donationNews->title,
            'content'       => $donationNews->content,
            'image'         => $donationNews->image,
        ];
    }
}
