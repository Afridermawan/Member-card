<?php

namespace App\Transformers;

use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\Article;

use League\Fractal;

class ArticleTagTransformer extends Fractal\TransformerAbstract
{
    public function transform(ArticleTag $data)
    {
    	$tag = Tag::find($data->tag_id)->first();

        $article = Article::find($data->article_id);
        return [
        	'id'		  => $data->article_id,
            "image"       => $article->thumbnail,
            "title"       => (string)$article->title ?: null,
            "content"     => (string)$article->content ?: null,
            'tag'		  => $tag->tag,
        ];
    }
}
