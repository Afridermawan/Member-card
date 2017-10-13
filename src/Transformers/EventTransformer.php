<?php

namespace App\Transformers;

use App\Models\Event;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    public function transform(Event $event)
    {
        return [
            'id'                    => $event->id,
            'name'                  => $event->name,
            'slug'                  => $event->slug,
            'description'           => $event->description,
            'image'                 => $event->image,
            'biaya_pendaftaran'     => $event->biaya_pendaftaran,
            'start_date'            => $event->start_date,
        ];
    }
}
