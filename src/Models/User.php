<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table    = 'users';
    public $timestamps  = true;
    protected $fillable = ['name', 'username', 'password', 'gender', 'email', 'phone', 'image', 'address', 'role_id', 'code', 'status'];

    public function joinRole()
    {
        $data = $this->join('roles', 'roles.id', '=', 'users.role_id')
                    ->select('roles.roles', 'roles.id as role_id','users.*');
        return $data;
    }
}
