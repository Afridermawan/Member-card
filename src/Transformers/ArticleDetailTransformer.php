<?php

namespace App\Transformers;

use App\Models\Article;
use App\Models\Category;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ArticleDetailTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        $category = Category::select('category')
        ->where('id', $article->category_id)->get();

        return [
            'title'         => $article->title,
            'slug'          => $article->slug,
            'category'      => $category[0]->category,
            'content'       => $article->content
        ];
    }
}
