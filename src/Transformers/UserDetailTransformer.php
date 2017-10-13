<?php

namespace App\Transformers;

use App\Models\User;
use App\Models\Role;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class UserDetailTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'                => $user->id,
            'username'          => $user->username,
            'password'          => $user->password,
            'email'             => $user->email,
            'phone'             => $user->phone,
            'image'             => (string)$user->image ?: null
        ];
    }
}
