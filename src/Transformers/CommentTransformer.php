<?php

namespace App\Transformers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Article;

use League\Fractal;

class CommentTransformer extends Fractal\TransformerAbstract
{
    public function transform(Comment $data)
    {
    	$user = User::find($data->user_id);

        $article = Article::find($data->article_id);
        return [
            "id"         => $data->id,
            "username"   => $user->username,
            "image"      => $user->image,
            "title" 	 => $article->title,
            "comment"    => $data->comment,
            "created_at" => $data->created_at,
        ];
    }
}
