<?php

namespace App\Controllers\Api;

use App\Models\Article;
use App\Transformers\ArticleTransformer;
use App\Transformers\ArticleTagTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\CommentTransformer;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\Token;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ScrapingSource;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Cocur\Slugify\Slugify;
use App\Models\Request;

class ArticleController extends Controller
{

    public function getArticle($request, $response)
    {

        $getArticle = Article::where('title', 'like', '%'.
                    $request->getQueryParam('search').'%')->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getArticle) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getQueryParam('page') ? $request->getQueryParam('page') : 1;
                $articles = Article::where('title', 'like', '%'.
                    $request->getQueryParam('search').'%')->orderBy('created_at', 'desc')
                    ->paginate($limit, ['*'], 'page', $page);
                $articles->setPath($this->url_api . '/article');
                $resource = new Collection($articles->items(), new ArticleTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($articles));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            else :

                $resource = new Collection($getArticle, new ArticleTransformer);
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                		'data'	=>	$data
                	]);

            endif;

        else :

            $data = $this->responseDetail(404, true, 'Data tidak tersedia');

        endif;

        return $data;

    }

    public function getArticleTag($request, $response)
    {

        $getArticle = ArticleTag::all();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);
        if ($getArticle) :
            if ($request->hasHeader('limit')) :

                $limit = $request->getHeaderLine('limit');
                $page    = $request->getQueryParam('page') ? $request->getQueryParam('page') : 1;
                $article = ArticleTag::paginate($limit, ['*'], 'page', $page);
                $article->setPath($this->url_api . '/article/tag');
                $resource = new Collection($article->items(), new ArticleTagTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($article));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                        'data'  =>  $data
                    ]);

            else :

                $resource = new Collection($getArticle, new ArticleTagTransformer);
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                        'data'  =>  $data
                    ]);

            endif;

        else :

            $data = $this->responseDetail(404, true, 'Data tidak tersedia');

        endif;

        return $data;

    }

    public function getArticleTagId($request, $response, $args)
    {

        $find_article = ArticleTag::where('id', $args['id'])->first();
        if ($find_article) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_article, new ArticleTagTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_article_releated = ArticleTag::where([
                ['id','<',$find_article->id]])
                ->limit(3)->get();
            $count_article_releated = count($data_article_releated);
            if ($count_article_releated > 0) :

                $resource_releated = new Collection($data_article_releated,
                    new ArticleTagTransformer);
                $data_article_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Artikel Terkait Ditemukan';
                $result = $data_article_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Artikel Terkait';
                $result = $data_article_releated;
            endif;

            $article_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $article_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }
    public function getArticleDetailSlug($request, $response, $args)
    {

        $find_article = Article::where('slug', $args['slug'])->first();
        if ($find_article) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_article, new ArticleTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_article_releated = Article::where([
                ['category_id', $find_article->category_id],
                ['id','<',$find_article->id]])
                ->limit(3)->get();
            $count_article_releated = count($data_article_releated);
            if ($count_article_releated > 0) :

                $resource_releated = new Collection($data_article_releated,
                    new ArticleTransformer);
                $data_article_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Artikel Terkait Ditemukan';
                $result = $data_article_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Artikel Terkait';
                $result = $data_article_releated;
            endif;

            $article_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $article_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function getArticleDetailId($request, $response, $args)
    {

        $find_article = Article::where('id', $args['id'])->first();
        if ($find_article) :
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer);
            $resource = new Item($find_article, new ArticleTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data_article_releated = Article::where([
                ['id',$find_article->id]])
                ->limit(3)->get();
            $count_article_releated = count($data_article_releated);
            if ($count_article_releated > 0) :

                $resource_releated = new Collection($data_article_releated,
                    new ArticleTransformer);
                $data_article_releated = $fractal->createData($resource_releated)
                                        ->toArray();
                $code = 200;
                $error = false;
                $message = 'Artikel Terkait Ditemukan';
                $result = $data_article_releated;
            else :
                $code = 200;
                $error = false;
                $message = 'Tidak Ada Artikel Terkait';
                $result = $data_article_releated;
            endif;

            $article_releated = [
                'code'  => $code,
                'error' =>  $error,
                'message' => $message,
                'data'  => $result,
            ];

            $data = $this->responseDetail(200, false, 'Data ditemukan', [
                    'data'              =>  $data,
                    'article_releated'  =>  $article_releated
            ]);

        else :

            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');

        endif;

        return $data;

    }

    public function getCommentId($request, $response, $args)
    {
        $comment = new Comment;
        $getComment = $comment->where('id', $args['id'])->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);

        if (count($getComment) > 0) {

            $resource = new Collection($getComment, new CommentTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data = $this->responseDetail(200, false, 'Data tersedia', [
                'data'  =>  $data
            ]);

        } else {

            $data = $this->responseDetail(200, false, 'Data Tidak Tersedia', [
                'data'  =>  $getComment
            ]);
        }

        return $data;
    }

    public function getCommentArticleId($request, $response, $args)
    {
        $comment = new Comment;
        $getComment = $comment->where('article_id', $args['id'])->get();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);

        if (count($getComment) > 0) {

            $resource = new Collection($getComment, new CommentTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data = $this->responseDetail(200, false, 'Data tersedia', [
                'data'  =>  $data
            ]);

        } else {

            $data = $this->responseDetail(200, false, 'Data Tidak Tersedia', [
                'data'  =>  $getComment
            ]);
        }

        return $data;
    }

    public function postComment($request, $response, $args)
    {
        $id = Token::where('token', $request->getHeader('Authorization')[0])->first();

        $this->validator
        ->rule('required', ['comment'])
        ->message('{field} tidak boleh kosong!')
        ->label('Comment');
        $this->validator->rule('lengthMax', ['comment',], 255);
        $this->validator->rule('lengthMin', ['comment'], 3);

        $find_article = Article::where('id', $args['id'])->first();

        if ($this->validator->validate()) :
            if ($find_article) :
                $saveComment = new Comment;
                $saveComment->article_id    = $args['id'];
                $saveComment->user_id       = $id->user_id;
                $saveComment->comment       = $request->getParam('comment');
                $saveComment->save();

                $data = $this->responseDetail(201, false, 'Data tersedia', [
                    'data'  =>  $saveComment
                ]);

            else :
                $data = $this->responseDetail(401, true, 'Id Article salah!', [
                    'data'  =>  $find_article
                ]);
            endif;
        else :
                $data = $this->responseDetail(400, true, $this->validator->errors());
        endif;

        return $data;
    }

    public function getCategory($request, $response)
    {

        $getCategory = Category::all();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);

        if (count($getCategory)>0) :
            $resource = new Collection($getCategory, new CategoryTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data = $this->responseDetail(200, false, 'Data tersedia', [
                'data'  =>  $data
            ]);

        else :

            $data = $this->responseDetail(400, true, 'Data tidak tersedia', [
                'data'  =>  $getCategory
            ]);

        endif;

        return $data;

    }

    public function getCategoryArticle($request, $response, $id)
    {

        $getCategory = Category::all();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);

        if (count($getCategory)>0) :

            $resource = new Collection($getCategory, new CategoryTransformer);
            $data = $fractal->createData($resource)->toArray();

            $data = $this->responseDetail(200, false, 'Data tersedia', [
                'data'  =>  $data
            ]);

        else :

            $data = $this->responseDetail(200, false, 'Data tidak tersedia', [
                'data'  =>  $getCategory
            ]);

        endif;

        return $data;
    }

    public function getCategoryDetail($request, $response, $args)
    {
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);

        if ($request->hasHeader('limit')) :
            $limit = $request->getHeaderLine('limit');
            $page  = $request->getParam('page') ? $request->getParam('page') : 1;
            $articles  = Article::where([
                ['category_id', $args['id']],
                ['title', 'like', '%'.$request->getParam('search').'%']
            ])->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page);
            if (count($articles)>0) :
                $articles->setPath($this->url_api . '/category/article/' . $args['id']);
                $resource = new Collection($articles->items(), new ArticleTransformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($articles));
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                    'data'  =>  $data
                ]);

            else :

                $data = $this->responseDetail(200, false, 'Data tidak tersedia', [
                    'data'  =>  $data
                ]);

            endif;

        else :

            $data  = Article::where([
                ['category_id', $args['id']],
                ['title', 'like', '%'.$request->getParam('search').'%']
            ])->orderBy('created_at', 'desc')->get();

            if (count($data)>0) :

                $resource = new Collection($data, new Articletransformer);
                $data = $fractal->createData($resource)->toArray();

                $data = $this->responseDetail(200, false, 'Data tersedia', [
                    'data'  =>  $data
                ]);

            else :

                $data = $this->responseDetail(200, false, 'Data tidak tersedia', [
                    'data'  =>  $data
                ]);

            endif;

        endif;

        return $data;

    }

    public function postArticle($request, $response)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['title'],
                    ['content'],
                ],
            ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {

            $base = $request->getUri()->getBaseUrl();

            if (!empty($_FILES['thumbnail']['name'])) {
                $storage = new \Upload\Storage\FileSystem('assets/img');
                $image = new \Upload\File('thumbnail', $storage);
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
                $thumbnailName = $base.'/assets/img/'.$image->getNameWithExtension();

            } else {
                $thumbnailName = $base.'/assets/img/article.png';
            }

            $slugify = new Slugify();
            $title = $request->getParam('title');

            $datax = [
                'title'           => $request->getParam('title'),
                // 'slug'            => str_replace(' ', '-', strtolower($request->getParam('title')))
                //                     . '-' . str_random(8),
                'slug'            => $slugify->slugify($title). '-' . strtolower(str_random(8)),
                'content'         => $request->getParam('content'),
                'thumbnail'       => $thumbnailName
            ];

            $saveArticle = Article::create($datax);

            $data = $this->responseDetail(201, false, 'Berhasil menambah data', [
                'data'  =>  $saveArticle
            ]);
        } else {
            $data = $this->responseDetail(401, true, 'Ada kesalahan saat menambah data');
        }

        return $data;
    }

    public function destroy($request, $response, $args)
    {
        $article = new Article;
        $getArticle = $article->find($args['id']);

        if ($getArticle) {
            $getArticle->delete();
            $data = $this->responseDetail(200, false, 'Berhasil menghapus data');
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat mengahpus data');
        }

        return $data;
    }

    public function putArticle($request, $response, $args)
    {
        $insert = $request->getParsedBody();
          $rules = [
            'required' => [
                    ['title'],
                    ['content'],
                ],
            ];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {

            $base = $request->getUri()->getBaseUrl();

            if (!empty($_FILES['thumbnail']['name'])) {
                $storage = new \Upload\Storage\FileSystem('assets/img');
                $image = new \Upload\File('thumbnail', $storage);
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
                $thumbnailName = $base.'/assets/img/'.$image->getNameWithExtension();

            } else {
                $thumbnailName = $base.'/assets/img/article.png';
            }

            $slugify = new Slugify();
            $title = $request->getParam('title');

            $datax = [
                'title'           => $request->getParam('title'),
                // 'slug'            => str_replace(' ', '-', strtolower($request->getParam('title')))
                //                     . '-' . str_random(8),
                'slug'            => $slugify->slugify($title). '-' . strtolower(str_random(8)),
                'content'         => $request->getParam('content'),
                'thumbnail'       => $thumbnailName
            ];

            $saveArticle = Article::update($datax);
            $data = $this->responseDetail(200, false, 'Berhasil memperbaharui data', [
                'data'  =>  $article
            ]);
        } else {
            $data = $this->responseDetail(400, true, 'Ada kesalahan saat memperbaharui data');
        }

        return $data;
    }

    public function getArticleComment($request, $response)
    {

        $getComment = Comment::all();
        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer);

        if (count($getComment)>0) :
            $resource = new Collection($getComment, new CommentTransformer);
            $data = $fractal->createData($resource)->toArray();
            $data = $this->responseDetail(200, false, 'Data tersedia', [
                'data'  =>  $data
            ]);

        else :

            $data = $this->responseDetail(400, true, 'Data tidak tersedia', [
                'data'  =>  $getComment
            ]);

        endif;

        return $data;

    }
}
