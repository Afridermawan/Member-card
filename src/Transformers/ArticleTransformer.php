<?php

namespace App\Transformers;

use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleTag;
use App\Models\Tag;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        $base_api = "http://" . $_SERVER['SERVER_NAME'].'/api/article/';

        $category = Category::select('category')
        ->where('id', $article->category_id)->first();

        $tags = ArticleTag::select('tags.id','tags.tag')
        ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
        ->where('article_tags.article_id', $article->id)->get();

        return [
            'id'            => $article->id,
            'title'         => $article->title,
            'slug'          => $article->slug,
            'tag'           => $tags,
            'content'       => $article->content,
            'thumbnail'     => $article->thumbnail
        ];
    }
}
