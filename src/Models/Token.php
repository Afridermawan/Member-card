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
        $data = User::join('tokens', 'users.id', '=', 'tokens.user_id')
                    ->leftjoin('requests', 'users.id', '=', 'requests.user_id')
                    ->select('tokens.user_id', 'tokens.token', 'users.*', 'requests.hak_akses')->get();
        return $data;
    }
}


 ?>
