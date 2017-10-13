<?php

namespace App\Transformers;

use App\Models\Role;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id'            =>  $role->id,
            'roles'         => (string)$role->roles ?: null,
        ];
    }
}
