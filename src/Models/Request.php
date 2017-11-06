<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table    = 'requests';
    public $timestamps  = true;
    protected $fillable = ['user_id','hak_akses'];

    public function joinUser()
    {
        $data = $this->join('users', 'users.id', '=', 'requests.user_id')
                    ->select('requests.id', 'users.username', 'users.image');
        return $data;
    }
}
