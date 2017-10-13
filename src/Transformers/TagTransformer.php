<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal;

class TagTransformer extends Fractal\TransformerAbstract
{
    public function transform(Tag $data)
    {
        return [
            'id'  => $data->id,
            "tag" => (string)$data->tag ?: null,
        ];
    }
}
