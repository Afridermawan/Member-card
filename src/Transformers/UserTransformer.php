<?php

namespace App\Transformers;

use App\Models\User;
use App\Models\Role;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'                => $user->id,
            'name'              => (string)$user->name ?: null,
            'username'          => $user->username,
            'password'          => $user->password,
            'gender'            => (string)$user->gender ?: null,
            'email'             => $user->email,
            'phone'             => $user->phone,
            'image'             => (string)$user->image ?: null,
            'address'           => (string)$user->address ?: null,
            'role_id'           => (string)$user->role_id ?: null,
            'code'              => (string)$user->code ?:null,
            'status'            => $user->status
        ];
    }
}
