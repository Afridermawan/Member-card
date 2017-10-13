<?php

namespace App\Controllers\Api;

use App\Models\Produk;
use App\Models\Token;
use App\Transformers\ProdukTransformer;
use App\Transformers\UserProdukTransformer;
use App\Models\UserProduk;
use App\Models\ScrapingSource;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Cocur\Slugify\Slugify;

class ProdukController extends Controller
{

    public function getProduk($request, $response)
    {
        $getProduk = Produk::where('name', 'like', '%'.
                    $request->getParam('search').'%')->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getProduk) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $produks = Produk::where('name', 'like', '%'.
                    $request->getParam('search').'%')->orderBy('created_at', 'desc')
                    ->where('deleted', 0)->paginate($limit, ['*'], 'page', $page);
                $produks->setPath($this->url_api . '/produk/list');
                $resource = new Collection($produks->items(), new ProdukTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($produks));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getProduk, new ProdukTransformer);
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

    public function getProdukDetailSlug($request, $response, $args)
    {

        $find_produk = Produk::where('slug', $args['slug'])->first();
        if ($find_produk) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_produk, new ProdukTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_produk_releated = Produk::where([
                ['id','<',$find_produk->id]])
                ->limit(3)->get();
            $count_produk_releated = count($data_produk_releated);
            if ($count_produk_releated > 0) :

                $resource_releated = new Collection($data_produk_releated,
                    new ProdukTransformer);
                $data_produk_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Produk Terkait Ditemukan';
                $result = $data_produk_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Produk Terkait';
                $result = $data_produk_releated;
            endif;

            $produk_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $produk_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function getProdukDetailId($request, $response, $args)
    {

        $find_produk = Produk::where('id', $args['id'])->first();
        if ($find_produk) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_produk, new ProdukTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_produk_releated = Produk::where([
                ['id','<',$find_produk->id]])
                ->limit(3)->get();
            $count_produk_releated = count($data_produk_releated);
            if ($count_produk_releated > 0) :

                $resource_releated = new Collection($data_produk_releated,
                    new ProdukTransformer);
                $data_produk_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Produk Terkait Ditemukan';
                $result = $data_produk_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Produk Terkait';
                $result = $data_produk_releated;
            endif;

            $produk_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $produk_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }


    public function addProduk($request, $response)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['name'],
                    ['harga'],
                ],
            ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {
            $base = $request->getUri()->getBaseUrl();

            if (!empty($_FILES['image']['name'])) {
                $storage = new \Upload\Storage\FileSystem('assets/img');
                $image = new \Upload\File('image', $storage);
                $image->setName(uniqid());
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('1M') 
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
                $imageName = $base.'/assets/img/produk.jpg';
            }

            $slugify = new Slugify();
            $name = $request->getParam('name');

            try {
                $produk = new Produk;
                $produk->name           = $insert['name'];
                $produk->harga          = $insert['harga'];
                $produk->description    = $insert['description'];
                $produk->slug           = $name;
                $produk->image          = $imageName;
                $produk->stok           = $insert['stok'];
                $produk->save();

                $data = $this->responseDetail(201, false, 'Berhasil menambah data', [
                      'data'  => $produk
                ]);
            } catch (Exception $e) {
                $data  = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(401, true, $this->validator->errors());
         }

         return $data;
    }

    public function softdelete($request, $response, $args)
    {
        $produk = New Produk;
        $get = $produk->find($args['id']);

        if ($get) {
            $find_produk = $get;
            $find_produk->deleted = 1;
            $find_produk->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $find_produk
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat menghapus data');
        }

        return $data;
    }

    public function restore($request, $response, $args)
    {
        $produk = New Produk;
        $get = $produk->find($args['id']);

        if ($get) {
            $find_produk = $get;
            $find_produk->deleted = 0;
            $find_produk->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dikembalikan', [
                'data'  =>  $find_produk
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat mengembalikan data');
        }

        return $data;
    }

    public function putProduk($request, $response, $args)
    {
        $insert = $request->getParsedBody();
        $rules = [
          'required' => [
                  ['name'],
                  ['harga'],
              ],
          ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {
            $base = $request->getUri()->getBaseUrl();

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
                $imageName = $base.'/assets/img/produk.jpg';
            }

            $slugify = new Slugify();
            $name = $request->getParam('name');

            try {
                $produk = Produk::where('id', $args['id'])->first();
                $produk->name           = $insert['name'];
                $produk->harga          = $insert['harga'];
                $produk->description    = $insert['description'];
                $produk->slug           = $name;
                $produk->image          = $imageName;
                $produk->harga          = $insert['harga'];
                $produk->stok           = $insert['stok'];
                $produk->save();

                $data = $this->responseDetail(200, false, 'Berhasil memperbaharui data', [
                      'data'  => $produk
                ]);
            } catch (Exception $e) {
                $data = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
         }

         return $data;
    }

    public function buy($request, $response, $args)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $insert = $request->getParsedBody();

        $barang = Produk::find($args['id']);

        $total_harga = ($insert['kuantitas'] * $barang->harga );

        if ($barang) {

            try {
                $produk = new UserProduk;
                $produk->user_id           = $id->user_id;
                $produk->produk_id         = $args['id'];
                $produk->kuantitas         = $insert['kuantitas'];
                $produk->total_harga       = $total_harga;
                $produk->save();

                $find_produk = UserProduk::where('id', $produk->id)->first();
                $fractal = new Manager();
                $fractal->setSerializer(new ArraySerializer);
                $resource = new Item($find_produk, new UserProdukTransformer);
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Berhasil membeli barang', [
                      'data'  => $data
                ]);
            } catch (Exception $e) {
                $data = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
         }

         return $data;
    }

    public function listItems($request, $response, $args)
    {
        $user = new UserProduk;
        $getUserProduk = $user->get();

        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getUserProduk) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $userProduk = $user->orderBy('created_at', 'DESC')->paginate($limit, ['*'], 'page', $page);
                $userProduk->setPath($this->url_api . '/produk/list/items');
                $resource = new Collection($userProduk->items(), new UserProdukTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($userProduk));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getUserProduk, new UserProdukTransformer);
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

    public function findItems($request, $response, $args)
    {
        $produk = new UserProduk();
        $find_produk = $produk->where('id', $args['id'])->first();

        if ($find_produk) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_produk, new UserProdukTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_produk_releated = $produk->where('id', $args['id'])->get();
            $count_produk_releated = count($data_produk_releated);
            if ($count_produk_releated > 0) :

                $resource_releated = new Collection($data_produk_releated,
                    new UserProdukTransformer);
                $data_produk_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Produk Terkait Ditemukan';
                $result = $data_produk_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Produk Terkait';
                $result = $data_produk_releated;
            endif;

            $produk_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'produk_releated'  =>  $produk_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function removeBuyerProduct($request, $response, $args)
    {
        $userProduk = New UserProduk;
        $get = $userProduk->find($args['id']);

        if ($get) {
            $find_produk = $get;
            $find_produk->deleted = 1;
            $find_produk->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $find_produk
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat menghapus data');
        }

        return $data;
    }

    public function editBuy($request, $response, $args)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $insert = $request->getParsedBody();


        $barang = Produk::find($args['id']);

        $total_harga = ($insert['kuantitas'] * $barang->harga );

        if ($barang) {

            try {
                $produk = UserProduk::where('id', $args['id'])->first();
                $produk->user_id           = $id->user_id;
                $produk->produk_id         = $args['id'];
                $produk->kuantitas         = $insert['kuantitas'];
                $produk->total_harga       = $total_harga;
                $produk->save();


                $data = $this->responseDetail(200, false, 'Berhasil mengedit pembelian barang', [
                      'data'  => $produk
                ]);
            } catch (Exception $e) {
                $data = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
         }

         return $data;
    }
}
