<?php

namespace App\Controllers\Api;

use App\Models\DonationNews;
use App\Models\Token;
use App\Transformers\DonationNewsTransformer;
use App\Models\ScrapingSource;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Cocur\Slugify\Slugify;

class DonationNewsController extends Controller
{

    public function getDonation($request, $response)
    {
        $getDonationNews = DonationNews::where('title', 'like', '%'.
                    $request->getParam('search').'%')->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getDonationNews) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $donations = DonationNews::where('title', 'like', '%'.
                    $request->getParam('search').'%')->orderBy('created_at', 'desc')
                    ->where('deleted', 0)->paginate($limit, ['*'], 'page', $page);
                $donations->setPath($this->url_api . '/donation-news/list');
                $resource = new Collection($donations->items(), new DonationNewsTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($donations));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getDonationNews, new DonationNewsTransformer);
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

    public function getDonationNewsId($request, $response, $args)
    {

        $find_donation = DonationNews::where('id', $args['id'])->first();
        if ($find_donation) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_donation, new DonationNewsTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_donation_releated = DonationNews::where([
                ['id','<',$find_donation->id]])
                ->limit(3)->get();
            $count_donation_releated = count($data_donation_releated);
            if ($count_donation_releated > 0) :

                $resource_releated = new Collection($data_donation_releated,
                    new DonationNewsTransformer);
                $data_donation_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Donation-news Terkait Ditemukan';
                $result = $data_donation_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Donation-news Terkait';
                $result = $data_donation_releated;
            endif;

            $donation_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $donation_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }


    public function addDonationNews($request, $response)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['title'],
                    ['content'],
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
                    new \Upload\Validation\Size('5M')
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
                $imageName = $base.'/assets/img/donasi.png';
            }

            $slugify = new Slugify();
            $name = $request->getParam('name');

            try {
                $donasi = new DonationNews;
                $donasi->title           = $insert['title'];
                $donasi->content         = $insert['content'];
                $donasi->image           = $imageName;
                $donasi->save();

                $data = $this->responseDetail(201, false, 'Berhasil menambah data', [
                      'data'  => $donasi
                ]);
            } catch (Exception $e) {
                $data  = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(401, true, $this->validator->errors());
         }

         return $data;
    }

    public function remove($request, $response, $args)
    {
        $donasi = New DonationNews;
        $get = $donasi->find($args['id']);

        if ($get) {
            $find_donasi = $get;
            $find_donasi->delete();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $find_donasi
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat menghapus data');
        }

        return $data;
    }

    public function putDonation($request, $response, $args)
    {
        $insert = $request->getParsedBody();
        $rules = [
          'required' => [
                  ['title'],
                  ['content'],
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
                    new \Upload\Validation\Size('5M')
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
                $imageName = $base.'/assets/img/donasi.jpg';
            }

            $slugify = new Slugify();
            $name = $request->getParam('name');

            try {
                $donasi = DonationNews::where('id', $args['id'])->first();
                $donasi->title           = $insert['title'];
                $donasi->content         = $insert['content'];
                $donasi->image           = $imageName;
                $donasi->save();

                $data = $this->responseDetail(200, false, 'Berhasil memperbaharui data', [
                      'data'  => $donasi
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
