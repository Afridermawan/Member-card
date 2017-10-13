<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Token extends Model
{
    protected $table = 'tokens';
    protected $primarykey = 'id';
    protected $fillable = ['user_id', 'token', 'login_at'];
    public $timestamps = false;

    public function joinUser()
    {
        $data = $this->join('users', 'users.id', '=', 'tokens.user_id')
                    ->select('tokens.user_id', 'tokens.token', 'users.*');
        return $data;
    }
}


 ?>
