<?php

namespace App\Transformers;

use App\Models\UserEvent;
use App\Models\Event;
use App\Models\User;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class UserEventTransformer extends TransformerAbstract
{
    public function transform(UserEvent $userEvent)
    {
        $user = User::find($userEvent->user_id);

        $event = Event::find($userEvent->event_id);

        return [
            'id'                        => $userEvent->id,
            'username'                  => $user->username,
            'name'                      => $event->name,
            'image'                     => $event->image,
            'biaya_pendaftaran'         => $event->biaya_pendaftaran,
            'kuantitas'                 => $userEvent->kuantitas,
            'total_harga'               => $userEvent->total_harga
        ];
    }
}
