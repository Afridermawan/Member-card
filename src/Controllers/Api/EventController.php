<?php

namespace App\Controllers\Api;

use App\Models\Event;
use App\Models\Token;
use App\Transformers\EventTransformer;
use App\Transformers\UserEventTransformer;
use App\Models\UserEvent;
use App\Models\ScrapingSource;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Cocur\Slugify\Slugify;

class EventController extends Controller
{

    public function getEvent($request, $response)
    {

        $getEvent = Event::where('name', 'like', '%'.
                    $request->getParam('search').'%')->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getEvent) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $events = Event::where('name', 'like', '%'.
                    $request->getParam('search').'%')->orderBy('created_at', 'desc')
                    ->where('deleted', 0)->paginate($limit, ['*'], 'page', $page);
                $events->setPath($this->url_api . '/event/list');
                $resource = new Collection($events->items(), new EventTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($events));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getEvent, new EventTransformer);
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

    public function getEventDetailSlug($request, $response, $args)
    {

        $find_event = Event::where('slug', $args['slug'])->first();
        if ($find_event) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_event, new EventTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_event_releated = Event::where([
                ['id','<',$find_event->id]])
                ->limit(3)->get();
            $count_event_releated = count($data_event_releated);
            if ($count_event_releated > 0) :

                $resource_releated = new Collection($data_event_releated,
                    new EventTransformer);
                $data_event_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Event Terkait Ditemukan';
                $result = $data_event_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Event Terkait';
                $result = $data_event_releated;
            endif;

            $event_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $event_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function getEventDetailId($request, $response, $args)
    {

        $find_event = Event::where('id', $args['id'])->first();
        if ($find_event) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_event, new EventTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_event_releated = Event::where([
                ['id','<',$find_event->id]])
                ->limit(3)->get();
            $count_event_releated = count($data_event_releated);
            if ($count_event_releated > 0) :

                $resource_releated = new Collection($data_event_releated,
                    new EventTransformer);
                $data_event_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Event Terkait Ditemukan';
                $result = $data_event_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Event Terkait';
                $result = $data_event_releated;
            endif;

            $event_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $event_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function addEvent($request, $response)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['name'],
                    ['description'],
                    ['biaya_pendaftaran'],
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
                $imageName = $base.'/assets/img/events.jpg';
            }

            $slugify = new Slugify();
            $name = $request->getParam('name');

            try {
                $event = new Event;
                $event->name                = $insert['name'];
                $event->description         = $insert['description'];
                $event->slug                = $name;
                $event->image               = $imageName;
                $event->biaya_pendaftaran   = $insert['biaya_pendaftaran'];
                $event->start_date          = $insert['start_date'];
                $event->save();

                $data = $this->responseDetail(201, false, 'Berhasil menambah data', [
                      'data'  => $event
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
        $event = New Event;
        $get = $event->find($args['id']);

        if ($get) {
            $find_event = $get;
            $find_event->deleted = 1;
            $find_event->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $find_event
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat menghapus data');
        }

        return $data;
    }

    public function restore($request, $response, $args)
    {
        $event = New Event;
        $get = $event->find($args['id']);

        if ($get) {
            $find_event = $get;
            $find_event->deleted = 0;
            $find_event->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dikembalikan', [
                'data'  =>  $find_event
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat mengembalikan data');
        }

        return $data;
    }

    public function putEvent($request, $response, $args)
    {
        $insert = $request->getParsedBody();
        $rules = [
            'required' => [
                    ['name'],
                    ['description'],
                    ['biaya_pendaftaran'],
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
                $imageName = $base.'/assets/img/events.jpg';
            }

            $slugify = new Slugify();
            $name = $request->getParam('name');

            try {
                $event = Event::where('id', $args['id'])->first();
                $event->name                = $insert['name'];
                $event->description         = $insert['description'];
                $event->slug                = $name;
                $event->image               = $imageName;
                $event->biaya_pendaftaran   = $insert['biaya_pendaftaran'];
                $event->start_date          = $insert['start_date'];
                $event->save();

                $data = $this->responseDetail(200, false, 'Berhasil memperbaharui data', [
                      'data'  => $event
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
        $rules = [
          'required' => [
                //   ['kuantitas'],
                //   ['event_id'],
              ],
          ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {

            $barang = Event::find($args['id']);

            $total_harga = ($insert['kuantitas'] * $barang->biaya_pendaftaran);

            try {
                $event = new UserEvent;
                $event->user_id           = $id->user_id;
                $event->event_id          = $args['id'];
                $event->kuantitas         = $insert['kuantitas'];
                $event->total_harga       = $total_harga;
                $event->save();

                $find_event = UserEvent::where('id', $event->id)->first();
                $fractal = new Manager();
                $fractal->setSerializer(new ArraySerializer);
                $resource = new Item($find_event, new UserEventTransformer);
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Lanjutkan pembayaran', [
                      'data'        =>   $data,
                ]);
            } catch (Exception $e) {
                $data = $e->getResponse();
            }

         } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
         }

         return $data;
    }

    public function pay($request, $response, $args)
    {
        $event = UserEvent::where('id', $args['id'])->first();

        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        $resource = new Item($event, new UserEventTransformer);
        $data->data = $fractal->createData($resource)->toArray();

        $transaction_details = array(
          'order_id'    =>  'ORD-EV'.date('YmdHis').rand(10,99),
          'gross_amount'=>  $event->total_harga, // no decimal allowed for creditcard
        );
        dd($transaction_details);
        $transaction = array(
            'transaction_details' => $transaction_details,
        );

        $snapToken = \Veritrans_Snap::getSnapToken($transaction);
        $data->token = $snapToken;

        return $this->responseDetail(200, false, 'Berhasil', [
            'data'  =>   $data
        ]);
    }


    public function listItems($request, $response, $args)
    {
        $event = new UserEvent;
        $getUserEvent = $event->where('user_id', 'like', '%'.
            $request->getParam('search').'%')->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getUserEvent) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getParam('page') ? $request->getParam('page') : 1;
                $userEvent = $event->orderBy('created_at', 'DESC')->where('user_id', 'like', '%'.
                    $request->getParam('search').'%')
                    ->paginate($limit, ['*'], 'page', $page);
                $userEvent->setPath($this->url_api . '/event/list/items');
                $resource = new Collection($userEvent->items(), new UserEventTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($userEvent));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                        'data'	=>	$data
                    ]);

            else :

                $resource = new Collection($getUserEvent, new UserEventTransformer);
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
        $event = new UserEvent();
        $find_event = $event->where('id', $args['id'])->first();

        if ($find_event) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_event, new UserEventTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_event_releated = $event->where('id', $args['id'])->get();
            $count_event_releated = count($data_event_releated);
            if ($count_event_releated > 0) :

                $resource_releated = new Collection($data_event_releated,
                    new UserEventTransformer);
                $data_event_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Event Terkait Ditemukan';
                $result = $data_event_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Event Terkait';
                $result = $data_event_releated;
            endif;

            $event_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $event_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function removeBuyerEvent($request, $response, $args)
    {
        $userEvent = New UserEvent;
        $get = $userEvent->find($args['id']);

        if ($get) {
            $find_event = $get;
            $find_event->deleted = 1;
            $find_event->update();
            $data = $this->responseDetail(200, false, 'Data berhasil dihapus', [
                'data'  =>  $find_event
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


        $barang = Event::find($args['id']);

        $total_harga = ($insert['kuantitas'] * $barang->biaya_pendaftaran );

        if ($barang) {

            try {
                $event = UserEvent::where('id', $args['id'])->first();
                $event->user_id           = $id->user_id;
                $event->event_id          = $args['id'];
                $event->kuantitas         = $insert['kuantitas'];
                $event->total_harga       = $total_harga;
                $event->save();


                $data = $this->responseDetail(200, false, 'Berhasil mengedit pembelian barang', [
                      'data'  => $event
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
