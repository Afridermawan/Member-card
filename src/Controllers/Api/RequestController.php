<?php
namespace App\Controllers\Api;

use App\Models\User;
use App\Models\Request;
use App\Models\Token;
use App\Extensions\Mailers\Mailer;

/**
 *
 */
class RequestController extends Controller
{
    public function index($request, $response)
    {
        $request = new Request;
        $get = $request->joinUser()->where('hak_akses', 0)->paginate(5);

        if ($get) {
            $data = $this->responseDetail(200, false, 'Berhasil', [
                'data'  =>  $get
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Error');
        }

        return $data;
    }

    public function getRequest($request, $response)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $findRequest = Request::where('user_id', $id->user_id)->first();

        if ($findRequest) {
            $data = $this->responseDetail(200, false, 'Berhasil', [
                'data'  =>  $findRequest
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Error');
        }

        return $data;
    }

    public function delete($request, $response, $args)
    {
        $request = Request::where('id', $args['id']);

        $request->delete();

        if ($request) {
            $data = $this->responseDetail(200, false, 'Berhasil');
        } else {
            $data = $this->responseDetail(400, true, 'Error');
        }

        return $data;
    }

    public function sendRequest($request, $response)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $user = Request::where('user_id', $id->user_id)->first();

        if ($user) {
            $data = $this->responseDetail(200, false, 'Berhasil mengirim request untuk mendapatkan akses ini');
        } else {
            $request = Request::create([
                'user_id'   =>  $id->user_id,
                'hak_akses'    =>  0,
            ]);

            $findRequest = Request::where('id', $request->id)->first();

            if ($request) {
                $data = $this->responseDetail(201, false, 'Berhasil mengirim request untuk mendapatkan akses ini', [
                    'data'  =>  $findRequest
                ]);
            } else {
                $data = $this->responseDetail(401, true, 'Error');
            }
        }

        return $data;

    }

    public function approveRequest($request, $response, $args)
    {
        $find = Request::where('id', $args['id'])->first();

        $user = User::where('id', $find->user_id)->first();

        $request = Request::where('id', $args['id'])->update(['hak_akses' => 1]);

        if ($request) {
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
            color: rgb(255,255,255);line-height: 1.25;">Izin Upgrade feature Member Card</td>
            <td width="32px"></td></tr>
            <tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr>
            <tr><td><table bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
            style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(240,240,240);
            border-bottom: 1.0px solid rgb(192,192,192);border-top: 0;" width="100%">
            <tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td>
            <td rowspan="3" width="32px"></td></tr>
            <tr><td><p>Yang terhormat '.$user->username.',</p>
            <p>Terima kasih telah berpartisipasi di Member Card.
            Silahkan login dan nikmati feature lebih dari web kami.</p>
            <p>Terima kasih, <br /><br /> Admin Member Card</p></td></tr>
            <tr height="32px"></tr></tbody></table></td></tr>
            <tr height="16"></tr>
            <tr><td style="max-width: 600.0px;font-family: Roboto-Regular , Helvetica , Arial , sans-serif;
            font-size: 10.0px;color: rgb(188,188,188);line-height: 1.5;"></td>
            </tr><tr><td></td></tr></tbody></table></body></html>';

            $mail = [
            'subject'   =>  'Member Card - Upgrade Feature',
            'from'      =>  'dev.membercard@gmail.com',
            'to'        =>  $user->email,
            'sender'    =>  'Member Card',
            'receiver'  =>  $user->name,
            'content'   =>  $content,
            ];
            $mailer = new Mailer;
            $mailer->send($mail);

            $data = $this->responseDetail(200, false, 'Persetujuan berhasil');
        } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());

        }

        return $data;
    }
}


 ?>
