<?php

namespace App\Controllers\Api;

use App\Transformers\UserTransformer;
use App\Transformers\UserDetailTransformer;
use App\Transformers\RoleTransformer;
use App\Models\User;
use App\Models\Role;
use App\Models\Register;
use App\Models\Token;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Cocur\Slugify\Slugify;
use App\Extensions\Mailers\Mailer;

class UserController extends Controller
{

    public function getUser($request, $response)
    {

        $getUser = User::all();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getUser) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $users = User::where('username', 'like', '%'.
                    $request->getParam('search').'%')->orderBy('created_at', 'desc')
                    ->where('deleted', 0)->paginate($limit, ['*'], 'page', $page);
                $users->setPath($this->url_api . '/user/list');
                $resource = new Collection($users->items(), new UserTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($users));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getUser, new UserTransformer);
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            endif;

        else :

            $data = $this->responseDetail(200, true, 'Data tidak tersedia');

        endif;

        return $data;

    }

    public function getUserDetail($request, $response, $args)
    {

        $find_user = User::where('id', $args['id'])->first();
        if ($find_user) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_user, new UserTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_user_releated = User::where([
                ['id','<',$find_user->id]])
                ->limit(3)->get();
            $count_user_releated = count($data_user_releated);
            if ($count_user_releated > 0) :

                $resource_releated = new Collection($data_user_releated,
                    new UserTransformer);
                $data_user_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'User Terkait Ditemukan';
                $result = $data_user_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada User Terkait';
                $result = $data_user_releated;
            endif;

            $user_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'user_releated'     =>  $user_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function register($request, $response)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['username'],
                    ['email'],
                    ['password'],
                    ['phone'],
                ],
            'email' =>  [
                ['email']
                ],
            'lengthMin' => [
                    [ 5, 'username'],
                    [ 5, 'password'],
                ],
            ];

        $this->validator->rules($rules);

        $oQRC = new \QRCode;
        $oQRC->fullName($request->getParam('username'))
            ->workPhone($request->getParam('phone'))
            ->email($request->getParam('email'))
            ->lang('en-US')
            ->finish();

        if ($this->validator->validate()) {

            $base = $request->getUri()->getBaseUrl();

            if (!empty($request->getUploadedFiles()['image'])) {
                $storage = new \Upload\Storage\FileSystem('assets/images');
                $image = new \Upload\File('image',$storage);

                $image->setName(uniqid('img-'.date('Ymd').'-'));
                $image->addValidations(array(
                new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                'image/jpg', 'image/jpeg', 'image/svg')),
                new \Upload\Validation\Size('2M')
                ));

                $image->upload();
                $imageName = $base.'/assets/img/'.$image->getNameWithExtension();

            } else {
                $imageName = $base.'/assets/img/avatar.svg';
            }

            $checkUsername = User::where('username', $insert['username'])->first();
            $checkEmail = User::where('email', $insert['email'])->first();

            if ($checkUsername && $checkEmail) {
                return $this->responseDetail(409, true, 'Email & username sudah digunakan');
            } elseif ($checkUsername) {
                return $this->responseDetail(409, true, 'Username sudah digunakan');
            } elseif ($checkEmail) {
                return $this->responseDetail(409, true, 'Email sudah digunakan');
            } else {
                $user = new User;
                $user->username    = $insert['username'];
                $user->email       = $insert['email'];
                $user->password    = password_hash($insert['password'], PASSWORD_BCRYPT);
                $user->phone       = $insert['phone'];
                $user->image       = $imageName;
                $user->role_id     = 2;
                $user->code        = $oQRC->get(300);;
                dd($user);
                $user->save();
                $token = md5(openssl_random_pseudo_bytes(8));

                $tokenId = Register::create([
                        'user_id'       => $user->id,
                        'token'         => $token,
                        'expired_date'  => date('Y-m-d H:i:s', strtotime('+7 day')),
                    ]);

                $activateUrl = '<a href ='.$base ."/activateaccount/".$token.'>
                <h3>AKTIFKAN AKUN</h3></a>';
                $content = '<html><head></head>
                <body style="font-family: Verdana;font-size: 12.0px;">
                <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600.0px;">
                <tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr><td align="left">
                </td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td>
                <table bgcolor="#ee6e73" border="0" cellpadding="0" cellspacing="0"
                style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(224,224,224);
                border-bottom: 0;" width="100%">
                <tbody><tr><td colspan="3" height="42px"></td></tr>
                <tr><td width="32px"></td>
                <td style="font-family: Roboto-Regular , Helvetica , Arial , sans-serif;font-size: 24.0px;
                color: rgb(255,255,255);line-height: 1.25;">Aktivasi Akun Member Card</td>
                <td width="32px"></td></tr>
                <tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr>
                <tr><td><table bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
                style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(240,240,240);
                border-bottom: 1.0px solid rgb(192,192,192);border-top: 0;" width="100%">
                <tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td>
                <td rowspan="3" width="32px"></td></tr>
                <tr><td><p>Yang terhormat '.$request->getParsedBody()['username'].',</p>
                <p>Terima kasih telah mendaftar di Member Card.
                Untuk mengaktifkan akun Anda, silakan klik tautan di bawah ini.</p>
                <div style="text-align: center;"><p>
                <strong style="text-align: center;font-size: 24.0px;font-weight: bold;">
                '.$activateUrl.'</strong></p></div>
                <p>Jika tautan tidak bekerja, Anda dapat menyalin atau mengetik kembali
                 tautan di bawah ini.</p>
                '.$base .'/activateaccount/'.$token.'<p><br>
                <p>Terima kasih, <br /><br /> Admin Member Card</p></td></tr>
                <tr height="32px"></tr></tbody></table></td></tr>
                <tr height="16"></tr>
                <tr><td style="max-width: 600.0px;font-family: Roboto-Regular , Helvetica , Arial , sans-serif;
                font-size: 10.0px;color: rgb(188,188,188);line-height: 1.5;"></td>
                </tr><tr><td></td></tr></tbody></table></body></html>';

                $mail = [
                'subject'   =>  'Member Card - Verifikasi Email',
                'from'      =>  'dev.membercard@gmail.com',
                'to'        =>  $user->email,
                'sender'    =>  'Member Card',
                'receiver'  =>  $user->name,
                'content'   =>  $content,
                ];
                $mailer = new Mailer;
                $mailer->send($mail);

                $data = $this->responseDetail(201, false, 'Pendaftaran berhasil, silahkan cek email untuk aktivasi akun', [
                      'data'  => $user
                ]);
            }
         } else {
            $data = $this->responseDetail(401, true, $this->validator->errors());
         }

         return $data;
    }

    public function activateaccount($request, $response, $args)
    {
        $users = new User;
        $registers = new Register;
        $userToken = Register::where('token', $args['token'])->first();

        $base = $request->getUri()->getBaseUrl();
        $now = date('Y-m-d H:i:s');
        if ($userToken && $userToken->expired_date > $now) {
            $user = $users->where('id', $userToken->user_id)
                        ->update(['status' => 1]);
            $register = $registers->find($userToken->id);
            $register->delete();

            $data = $this->responseDetail(200, false, 'Akun berhasil diaktivasi');
        } elseif ($userToken && $userToken->expired_date > $now) {
            $data = $this->responseDetail(400, true, 'Token telah kadaluarsa atau sudah tidak dapat digunakan');
        } else{
            $data = $this->responseDetail(400, true, 'Token salah atau anda belum mendaftar');
        }
            return $data;
    }

    public function delete($request, $response, $args)
    {
        $user = New User;
        $get = $user->find($args['id']);

        if ($get) {
            $findUser = $get;
            $findUser->delete();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $findUser
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat menghapus data');
        }

        return $data;
    }

    public function restore($request, $response, $args)
    {
        $user = New User;
        $get = $user->find($args['id']);

        if ($get) {
            $findUser = $get;
            $findUser->deleted = 0;
            $findUser->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dikembalikan', [
                'data'  =>  $findUser
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat mengembalikan data');
        }

        return $data;
    }

    public function putUser($request, $response, $args)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['username'],
                    ['email'],
                    // ['password'],
                    ['phone'],
                ],
            'email' =>  [
                ['email']
                ],
            'lengthMin' => [
                    [ 5, 'username'],
                    [ 5, 'password'],
                ],
            ];

        $this->validator->rules($rules);

        $oQRC = new \QRCode;
        $oQRC->fullName($request->getParam('username'))
            ->workPhone($request->getParam('phone'))
            ->email($request->getParam('email'))
            ->lang('en-US')
            ->finish();

        if ($this->validator->validate()) {
            $base = $request->getUri()->getBaseUrl();

            try {
                $user = User::where('id', $args['id'])->first();
                $user->username    = $insert['username'];
                $user->email       = $insert['email'];
                $user->password    = password_hash($insert['password'], PASSWORD_BCRYPT);
                $user->name        = $insert['name'];
                $user->gender      = $insert['gender'];
                $user->address     = $insert['address'];
                $user->phone       = $insert['phone'];
                $user->role_id     = 2;
                $user->code        = $oQRC->get(300);;
                $user->save();

                $data = $this->responseDetail(200, false, 'Berhasil memperbaharui data', [
                      'data'  => $user
                ]);
            } catch (Exception $e) {
                echo '<p><b>Exception launched!</b><br /><br />' .
                'Message: ' . $oExcept->getMessage() . '<br />' .
                'File: ' . $oExcept->getFile() . '<br />' .
                'Line: ' . $oExcept->getLine() . '<br />' .
                'Trace: <p/><pre>' . $e->getTraceAsString() . '</pre>';
            }

         } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
         }

         return $data;
    }

    public function editProfile($request, $response, $args)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['username'],
                    ['email'],
                    ['phone'],
                ],
            'email' =>  [
                ['email']
                ],
            'lengthMin' => [
                    [ 5, 'username'],
                    [ 5, 'password'],
                ],
            ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {
            $base = $request->getUri()->getBaseUrl();

                $user = User::where('id', $id->user_id)->first();
                $user->username    = $insert['username'];
                $user->email       = $insert['email'];
                $user->name        = $insert['name'];
                $user->gender      = $insert['gender'];
                $user->address     = $insert['address'];
                $user->phone       = $insert['phone'];
                $user->role_id     = 2;
                $user->save();

                $data = $this->responseDetail(200, false, 'Berhasil memperbaharui data', [
                      'data'  => $user
                ]);
         } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
         }

         return $data;
    }

    public function attempt($username, $password)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        $token = md5(openssl_random_pseudo_bytes(8));
        $tokens = new Token;
        $tokenId = Token::where('user_id', $user->id)->first();
        if (password_verify($password, $user->password)) {
            if ($tokenId) {
                $tokenId->update([
                    'login_at'      => date('Y-m-d H:i:s'),
                ]);
            } else {
                Token::create([
                    'user_id'       => $user->id,
                    'token'         => md5($token),
                    'login_at'      => date('Y-m-d H:i:s'),
                ]);
            }
            return true;
        }

        return false;
    }

    public function check($token)
    {
        return !is_null(Token::where('token', $token)->first());
    }

    public function login($request, $response)
    {
        $request = $request->getParsedBody();

        $auth = $this->auth->attempt(
            $request['username'],
            $request['password']
        );

        if (!$auth) {
            $data = $this->responseDetail(401, true, 'Username atau Password salah');
        } else {
            $user = User::where('username', $request['username'])->first();
            $token = new Token;
            $login = $token->joinUser()->where('user_id', $user->id)->first();

            $data = $this->responseDetail(200, false, 'Login berhasil', [
                'data'  => $login
            ]);
        }

        return $data;
    }

    public function logout($request, $response )
    {
        $id = Token::where('token', $request->getHeaderLine('Authorization'))->first();
        $data = $id->user_id;
        $id->delete($data);
        return $this->responseDetail(200, false, 'Logout berhasil');
    }

    public function forgotPassword($request, $response)
    {
        $users = new User;
        $registers = new Register;
        $findUser = User::where('email', $request->getParam('email'))->first();
        $base = $request->getUri()->getBaseUrl();
        if (!$findUser) {
            return $this->responseDetail(404, true, 'Email tidak terdaftar');
        } elseif ($findUser) {
            $token = str_shuffle('r3c0Ve12y').substr(md5(microtime()),rand(0,26),37);
            $tokenId = Register::create([
                    'user_id'       => $findUser->id,
                    'token'         => $token,
                    'expired_date'  => date('Y-m-d H:i:s', strtotime('+7 day')),
                ]);
            $resetUrl = '<a href ='.$base ."/password/reset/".$token.'>
            <h3>RESET PASSWORD</h3></a>';
            $content = '<html><head></head>
            <body style="margin: 0;padding: 0; font-family: Verdana;font-size: 12.0px;">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600.0px;">
            <tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr><td align="left">
            </td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td>
            <table bgcolor="#ee6e73" border="0" cellpadding="0" cellspacing="0"
             style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(224,224,224);
             border-bottom: 0;" width="100%">
            <tbody><tr><td colspan="3" height="42px"></td></tr>
            <tr><td width="32px"></td>
            <td style="font-family: Roboto-Regular , Helvetica , Arial , sans-serif;font-size: 24.0px;
            color: rgb(255,255,255);line-height: 1.25;">Setel Ulang Sandi Member Card</td>
            <td width="32px"></td></tr>
            <tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr>
            <tr><td><table bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
             style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(240,240,240);
             border-bottom: 1.0px solid rgb(192,192,192);border-top: 0;" width="100%">
            <tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td>
            <td rowspan="3" width="32px"></td></tr>
            <tr><td><p>Yang terhormat '.$findUser->name.',</p>
            <p>Baru-baru ini Anda meminta untuk menyetel ulang kata sandi akun Member Card Anda.
              Untuk mengubah kata sandi akun Anda, silakan ikuti tautan di bawah ini.</p>
              <div style="text-align: center;"><p>'.$resetUrl.'</p></div>
             <p>Jika tautan tidak bekerja, Anda dapat menyalin atau mengetik kembali
            tautan berikut.</p>
            <p>'.$base."/password/reset/".$token.'</p>
            <p>Jika Anda tidak seharusnya menerima email ini, mungkin pengguna lain
            memasukkan alamat email Anda secara tidak sengaja saat mencoba menyetel
            ulang sandi. Jika Anda tidak memulai permintaan ini, Anda tidak perlu
            melakukan tindakan lebih lanjut dan dapat mengabaikan email ini dengan aman.</p>
            <p> <br />Terima kasih, <br /><br /> Admin Member Card</p></td></tr>
            <tr height="32px"></tr></tbody></table></td></tr>
            <tr height="16"></tr>
            <tr><td style="max-width: 600.0px;font-family: Roboto-Regular , Helvetica , Arial , sans-serif;
            font-size: 10.0px;color: rgb(188,188,188);line-height: 1.5;"></td>
            </tr><tr><td></td></tr></tbody></table></body></html>';
            $mail = [
            'subject'   =>  'Setel Ulang Sandi',
            'from'      =>  'dev.membercard@gmail.com',
            'to'        =>  $findUser->email,
            'sender'    =>  'Member Card Account Recovery',
            'receiver'  =>  $findUser->username,
            'content'   =>  $content,
            ];
            $mailer = new Mailer;
            $mailer->send($mail);
            return $this->responseDetail(200, false, 'Silakan cek email anda untuk mengubah password');
        }
    }

    public function getResetPassword($request, $response, $args)
    {
        $findToken = Register::where('token', $args['token'])->first();
        if ($findToken) {
            $data = $this->responseDetail(200, false, 'Token diterima', [
                    'data' => $args['token']
                ]);
        } else {
            $data =  $this->responseDetail(404, true, 'Token salah');
        }
            return $data;
    }

    // Method change password from forgot password
    public function resetPassword($request, $response, $args)
    {
        $users = new User;
        $registers = new Register;
        $this->validator->rule('required', ['email', 'password']);
        $this->validator->rule('equals', 'password2', 'password');
        $this->validator->rule('email', 'email');
        $this->validator->rule('lengthMin', ['password'], 5);
        if ($this->validator->validate()) {
            $findUser = User::where('email', $request->getParam('email'))->first();
            $findToken = Register::where('token', $request->getParam('token'))->first();

            if ($findUser->id == $findToken->user_id) {

                $pass = $users->where('id', $findUser->id)->update([
                    'password'  => password_hash($request->getParam('password'), PASSWORD_BCRYPT)
                ]);

                $register = $registers->find($findToken->id);
                $newUser = User::where('email', $request->getParam('email'))->first();
                $register->delete();
                return $this->responseDetail(200, false, 'Password berhasil diperbarui', [
                    'data'  => $newUser
                ]);
            } else {
                return $this->responseDetail(404, true, 'Data tidak ditemukan', [
                    'data'  => [
                        'token' => $request->getParam('token')
                    ]
                ]);
            }
        } else {
            return $this->responseDetail(400, true, $this->validator->errors(), [
                'data'  => [
                    'token' => $request->getParam('token')
                ]
            ]);
        }
        return $data;
    }

    public function postImage($request , $response)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();
        $users = new User;
        $findUser = $users->where('id', $id->user_id)->first();

        $base = $request->getUri()->getBaseUrl();
        if ($findUser) {
            if (!empty($_FILES['image']['name'])) {
                $storage = new \Upload\Storage\FileSystem('assets/img');
                $image = new \Upload\File('image', $storage);
                $image->setName(uniqid());
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('2M')
                ));

                try {
                    // Success!
                    $image->upload();
                } catch (\Exception $e) {
                    // Fail!
                    $errors = $image->getErrors();
                }
                $imageName = $base.'/assets/img/'.$image->getNameWithExtension();

            } else {
                $imageName = $base.'/assets/img/avatar.svg';
            }

            $newId = $users->where('id', $id->user_id)->update([
                'image' =>  $imageName
            ]);

            $newUser = Token::where('id', $id->user_id)->first();

            return $this->responseDetail(200, false, 'Berhasil ', [
                'data'     => $newUser
            ]);
        } else {
            return $this->responseDetail(404, true, $this->validator->errors());
        }
    }
}
