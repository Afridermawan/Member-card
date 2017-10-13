<?php

namespace App\Controllers\Api;

use App\Models\Token;
use App\Models\User;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class FileSystemController extends Controller
{
	public function upload(Request $request, Response $response, $args)
	{ 
		$id = Token::where('token', $request->getHeader('Authorization')[0])->first();
		$users = new User;
        $findUser = $users->where('id', $id->user_id)->first();

        if (!$findUser) {
            return $this->responseDetail(404, true, $this->validator->errors());
        } else {
	        $header = $request->getHeader('extension');

			$content = file_get_contents('php://input');
			$flysystem = $this->fs;
			$nama_file = uniqid('img-'.date('Ymd').'-') . ".jpg";
			$flysystem->write('/img/' . $nama_file, $content);

	        $curent_path = 'assets/img/' . $nama_file;
	        // $new_path = '/img/' . $nama_file;

	        list($width, $height) = getimagesize($curent_path);

	        //jika memakai persentase
	        // $percent = 30/100;
	        // $newwidth = $width * $percent;
	        // $newheight = $height * $percent;
	        //jika menggunakan fix pixel (width 100, height auto)

	        $fix_width = 500;
	        $prosentase = $fix_width / $fix_width;
	        $newwidth = $fix_width;
	        $newheight = $height * $prosentase;

	        // Load
	        $thumb = imagecreatetruecolor($newwidth, $newheight);
	        $source = imagecreatefromjpeg($curent_path);

	        // Resize
	        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	        //output
	        ob_start();
	        imagejpeg($thumb);
	        $new_content = ob_get_contents();
	        ob_end_clean();
			$new_name = uniqid('img-'.date('YmdHis').'-') . ".jpg";
	        $flysystem->write('/img/' . $new_name, $new_content);
			$flysystem->delete('/img/' . $nama_file);
	        // Crop
	        // $curent_path = "assets/img/" .$nama_file;
	        // $source = imagecreatefromjpeg($curent_path);
	        // $size = min(imagesx($source), imagesy($source));
	        // $image_resize = imagecrop($source, ['x' => 0, 'y' => 0, 'width' => 300, 'height' => 300]);

	        // ob_start();
	        // imagejpeg($image_resize);
	        // $crop_content = ob_get_contents();
	        // ob_end_clean();

	        // $flysystem->write('/img/' . $nama_file, $crop_content);
	        $base = $request->getUri()->getBaseUrl();

	        $data = $users->where('id', $id->user_id)->first();

	        $newUser = $users->where('id', $id->user_id)->update([
	        	'image'	=>	$base . "/assets/img/" . $new_name
	        ]);
	        return $this->responseDetail(200, false, 'success', [
	            'data'     => $base . "/assets/img/" . $new_name
	        ]);
        }
    }
}
 ?>
