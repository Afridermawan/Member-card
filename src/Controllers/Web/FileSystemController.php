<?php 

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;
/**
* 
*/
class FileSystemController extends Controller
{
	public function getUpload($request, $response, $args)
    {
        $session = $_SESSION['login'];

        return $this->view->render($response, 'backend/user/user/upload', [
            'session'   =>  $session,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/web/pin/",
            'title'     =>  "Upload image" 
        ]);
    }
	
	public function upload($request, $response)
	{
        $session = $_SESSION['login'];

        try {
            $result = $this->client->request('POST', 'user/edit/image',[
                'form_params' => [
                    'user_id'      =>   $session->user_id,
                    'image'        =>   $request->getParam('image'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        if ($data->error == false) {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        }
    }
}

 ?>