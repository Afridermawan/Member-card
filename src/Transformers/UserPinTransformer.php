<?php

namespace App\Transformers;

use App\Models\User;
use App\Models\UserPin;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class userPinTransformer extends TransformerAbstract
{
    public function transform(UserPin $user_pin)
    {        
        $user = User::find($user_pin->user_id);

        return [
            'id'           => $user_pin->id,
            'user_id'      => $user->username,
            'pin'          => $user_pin->pin,
        ];
    }
}
