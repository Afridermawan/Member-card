<?php

namespace App\Controllers\Web;


use GuzzleHttp\Exception\BadResponseException as GuzzleException;

/**
*
*/
class DepositController extends Controller
{
    public function paymentMethod($request, $response, $args)
    {
        try {
            $result = $this->client_deposit->request('GET', 'deposit/payment-method');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        dd($data);
    }

    public function historyById($request, $response, $args)
    {
        try {
            $result = $this->client_deposit->request('GET', 'deposit/debit/'.$args['id']);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        dd($data);
    }

    public function history($request, $response)
    {
        try {
            $result = $this->client_deposit->request('POST', 'deposit/debit/history', [
                'form_params' => [
                    'email' =>  $request->getParam('email')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        dd($data);
    }

    public function checkSaldo($request, $response)
    {
        $session = $_SESSION['login'];

        try {
            $result = $this->client_deposit->request('POST', 'deposit/saldo', [
                'form_params' => [
                    'email' =>  $session->email
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();
		return $this->view->render($response, 'backend/user/user/detail', [
            'data'      => $data,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/event/",
            'title'     =>  "Info Saldo",
            'messages'  =>  $messages
        ]);
    }
    public function getKredit($request, $response)
    {
        try {
            $result = $this->client_deposit->request('GET', 'deposit/payment-method');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $session = $_SESSION['login'];

        return $this->view->render($response, 'backend/user/user/deposit', [
            'payment_method'    =>  $data,
            'base_url'          =>  "http://localhost:8000",
            'title'             =>  "Deposit",
            'session'           =>  $session,
        ]);
    }

    public function kredit($request, $response)
    {
        try {
            $result = $this->client_deposit->request('POST', 'customer/deposit', [
                'form_params' => [
                    'name'              =>  $request->getParam('username'),
                    'email'             =>  $request->getParam('email'),
                    'phone'             =>  $request->getParam('phone'),
                    'payment_method'    =>  $request->getParam('payment_method'),
                    'total'             =>  $request->getParam('total'),
                    'description'       =>  $request->getParam('description'),
                ]
            ]);

        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if ($data->status == 400) {
            $this->flash->addMessage('error', $data->status);
            return $response->withRedirect($this->router->pathFor('profile'));
        }else{
            $this->flash->addMessage('success', 'Silahkan cek email anda, untuk melanjutkan pembayaran');
            return $response->withRedirect($this->router->pathFor('profile'));
        }
    }

    public function debit($request, $response)
    {
        try {
            $result = $this->client_deposit->request('POST', 'deposit/debit', [
                'name'              =>  $request->getParam('name'),
                'total'             =>  $request->getParam('total'),
                'description'       =>  $request->getParam('description'),
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        dd($data);
    }

    public function historyDeposit($request, $response)
    {
        try {
            $result = $this->client_deposit->request('POST', 'deposit/history', [
                'form_params' => [
                    'email' =>  'sularto@gmail.com'
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        dd($data);
    }
}
