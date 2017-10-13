<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Article;
use App\Transformers\ArticleTransformer;
use League\Fractal;
use League\Fractal\Resource\Collection;

class CategoryTransformer extends Fractal\TransformerAbstract
{
    public function transform(Category $data)
    {
        $base_api = "http://" . $_SERVER['SERVER_NAME'].'/api/category/article/';

        return [
            "id"            => $data->id,
            "category"      => $data->category,
            "url_category"  => $base_api . $data->id,
            "article"       => Article::where('category_id', $data->id)->get(),
        ];
    }
}
