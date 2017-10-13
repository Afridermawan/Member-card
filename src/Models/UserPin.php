<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPin extends Model
{
    protected $table    = 'user_pin';
    public $timestamps  = true;
    protected $fillable = ['user_id', 'pin'];

    public function joinUser()
    {
        $data = $this->join('users', 'users.id', '=', 'user_pin.user_id')
                    ->select('users_pin.pin','users.username', 'users.email', 'users.phone', 'users.image', 'users.gender');
        return $data;
    }
}
