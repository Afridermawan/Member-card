<?php

namespace App\Controllers\Api;

use App\Models\User;
use App\Models\Token;
use App\Transformers\UserPinTransformer;
use App\Models\UserPin;
use App\Models\ScrapingSource;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Cocur\Slugify\Slugify;

class UserPinController extends Controller
{

    public function getPin($request, $response)
    {

        $getlist = UserPin::where('pin', 'like', '%'.
                    $request->getParam('search').'%')->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getlist) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $user_pin = UserPin::where('pin', 'like', '%'.
                    $request->getParam('search').'%')->orderBy('created_at', 'desc')
                    ->paginate($limit, ['*'], 'page', $page);
                $user_pin->setPath($this->url_api . '/pin/list');
                $resource = new Collection($user_pin->items(), new UserPinTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($user_pin));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getlist, new UserPinTransformer);
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

    public function getPinId($request, $response, $args)
    {

        $find_pin = UserPin::where('user_id', $args['id'])->first();

        if ($find_pin) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_pin, new UserPinTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_pin_releated = UserPin::where([
                ['user_id','<',$find_pin->id]])
                ->limit(3)->get();
            $count_pin_releated = count($data_pin_releated);
            if ($count_pin_releated > 0) :

                $resource_releated = new Collection($data_pin_releated,
                    new UserPinTransformer);
                $data_pin_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Pin Terkait Ditemukan';
                $result = $data_pin_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Pin Terkait';
                $result = $data_pin_releated;
            endif;

            $pin_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $pin_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function delete($request, $response, $args)
    {
        $pin = New UserPin;
        $get = $pin->find($args['id']);

        if ($get) {
            $find_pin = $get;
            $find_pin->delete();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $find_pin
            ]);
        } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
        }

        return $data;
    }

    public function restore($request, $response, $args)
    {
        $pin = New UserPin;
        $get = $pin->find($args['id']);

        if ($get) {
            $find_pin = $get;
            $find_pin->deleted = 0;
            $find_pin->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dikembalikan', [
                'data'  =>  $find_pin
            ]);
        } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
        }

        return $data;
    }

    public function putPin($request, $response, $args)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $insert = $request->getParsedBody();
        $rules = [
          'required' => [
                  ['pin'],
              ],
          ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {

            $user_pin = new UserPin;
            try {
                $pin = $user_pin->where('user_id', $id->user_id)->update([
                    'pin' => $insert['pin'] ]);

                $result = UserPin::where('user_id', $id->user_id)->first();
                $data = $this->responseDetail(201, false, 'Berhasil memperbaharui data', [
                      'data'  => $result
                ]);
            } catch (Exception $e) {
                $data = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(401, true, $this->validator->errors());
         }

         return $data;
    }

    public function addPin($request, $response, $args)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['pin'],
                ],
            ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {

            try {
                $pin = new UserPin;
                $pin->user_id        = $id->user_id;
                $pin->pin            = $insert['pin'];
                $pin->save();

                $data = $this->responseDetail(201, false, 'Berhasil menambah data', [
                      'data'  => $pin
                ]);
            } catch (Exception $e) {
                $data  = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(401, true, $this->validator->errors());
         }

         return $data;
    }

    public function checkPassword($request, $response)
    {
        $users = new User;
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();
        $user = User::where('id', $id->user_id)->first();

        if (empty($user)) {
            $data = $this->responseDetail(400, true, 'User tidak terdaftar');
        } else {
            $check = password_verify($request->getParam('password'), $user->password);

            if ($check) {
                $data = $this->responseDetail(200, false, 'Silahkan masukkan pin anda !');
            } else {
                $data = $this->responseDetail(400, true, 'Password salah');
            }
        }
        return $data;
    }
}
