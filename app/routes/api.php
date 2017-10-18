<?php

$app->get('/task/cron', 'App\Controllers\Api\CronController:activateaccount');
$app->group('/api', function () use ($app, $container){
    $app->get('/activateaccount/{token}', 'App\Controllers\Api\UserController:activateaccount'); 
    $app->post('/auth/signin', 'App\Controllers\Api\UserController:login');
    $app->post('/auth/signup', 'App\Controllers\Api\UserController:register'); 
    $app->get('/logout', 'App\Controllers\Api\UserController:logout');
    $app->post('/reset', 'App\Controllers\Api\UserController:forgotPassword');
    $app->get('/password/reset/{token}', 'App\Controllers\Api\UserController:getResetPassword');
    $app->post('/password/reset', 'App\Controllers\Api\UserController:resetPassword');

    $app->get('/article', 'App\Controllers\Api\ArticleController:getArticle');
    $app->post('/article', 'App\Controllers\Api\ArticleController:postArticle');
    $app->get('/article/tag', 'App\Controllers\Api\ArticleController:getArticleTag');
    $app->post('/tag', 'App\Controllers\Api\ArticleController:postAddTag');
    $app->get('/article/tag/{id}', 'App\Controllers\Api\ArticleController:getArticleTagId');
    $app->post('/article/{id}/update', 'App\Controllers\Api\ArticleController:putArticle');
    $app->get('/article/{id}/delete', 'App\Controllers\Api\ArticleController:destroy');
    $app->get('/article/{slug}', 'App\Controllers\Api\ArticleController:getArticleDetailSlug');
    $app->get('/article/{id}/detail', 'App\Controllers\Api\ArticleController:getArticleDetailId');
    $app->get('/article/{id}/comment', 'App\Controllers\Api\ArticleController:getCommentId');
    $app->get('/article/comment/{id}', 'App\Controllers\Api\ArticleController:getCommentArticleId');
    $app->post('/article/{id}/comment', 'App\Controllers\Api\ArticleController:postComment')->setName('article.comment');
    $app->get('/comment/article', 'App\Controllers\Api\ArticleController:getArticleComment');
    $app->get('/category/article', 'App\Controllers\Api\ArticleController:getCategory');
    $app->get('/category/article/{id}', 'App\Controllers\Api\ArticleController:getCategoryDetail');
    $app->get('/category_article', 'App\Controllers\Api\ArticleController:getCategoryArticle');

    $app->group('/user', function () use ($app, $container){
        $app->get('/list', 'App\Controllers\Api\UserController:getUser');
        $app->get('/{id}/detail', 'App\Controllers\Api\UserController:getUserDetail');
        $app->get('/{id}/delete', 'App\Controllers\Api\UserController:delete');
        $app->get('/{id}/restore', 'App\Controllers\Api\UserController:restore');
        $app->post('/{id}/edit', 'App\Controllers\Api\UserController:putUser');
        $app->post('/{id}/edit/profile', 'App\Controllers\Api\UserController:editProfile');
        $app->post('/edit/image', 'App\Controllers\Api\FileSystemController:upload');
        $app->post('/change/image', 'App\Controllers\Api\UserController:postImage')->setName('change.image');

    });
    $app->group('/produk', function () use ($app, $container){
        $app->get('/list', 'App\Controllers\Api\ProdukController:getProduk');
        $app->get('/{slug}/detail', 'App\Controllers\Api\ProdukController:getProdukDetailSlug');
        $app->get('/{id}/find', 'App\Controllers\Api\ProdukController:getProdukDetailId');
        $app->post('/add', 'App\Controllers\Api\ProdukController:addProduk');
        $app->get('/{id}/delete', 'App\Controllers\Api\ProdukController:softdelete');
        $app->get('/{id}/restore', 'App\Controllers\Api\ProdukController:restore');
        $app->post('/{id}/edit', 'App\Controllers\Api\ProdukController:putProduk');
        $app->post('/{id}/buy', 'App\Controllers\Api\ProdukController:buy');
        $app->get('/list/items', 'App\Controllers\Api\ProdukController:listItems');
        $app->get('/{id}/list/items', 'App\Controllers\Api\ProdukController:findItems');
        $app->get('/{id}/remove/produk/item', 'App\Controllers\Api\ProdukController:removeBuyerProduct');
        $app->post('/{id}/edit/buy', 'App\Controllers\Api\ProdukController:editBuy');
    });
    $app->group('/event', function () use ($app, $container){
        $app->get('/list', 'App\Controllers\Api\EventController:getEvent');
        $app->get('/{slug}/detail', 'App\Controllers\Api\EventController:getEventDetailSlug');
        $app->get('/{id}/find', 'App\Controllers\Api\EventController:getEventDetailId');
        $app->post('/add', 'App\Controllers\Api\EventController:addEvent');
        $app->get('/{id}/delete', 'App\Controllers\Api\EventController:softdelete');
        $app->get('/{id}/restore', 'App\Controllers\Api\EventController:restore');
        $app->post('/{id}/edit', 'App\Controllers\Api\EventController:putEvent');
        $app->post('/{id}/buy', 'App\Controllers\Api\EventController:buy');
        $app->get('/list/items', 'App\Controllers\Api\EventController:listItems');
        $app->get('/{id}/list/items', 'App\Controllers\Api\EventController:findItems');
        $app->get('/{id}/remove/event/item', 'App\Controllers\Api\EventController:removeBuyerEvent');
        $app->post('/{id}/edit/buy', 'App\Controllers\Api\EventController:editBuy');
    });
    $app->group('/pin', function () use ($app, $container){
        $app->post('/check/password', 'App\Controllers\Api\UserPinController:checkPassword');
        $app->get('/list', 'App\Controllers\Api\UserPinController:getPin');
        $app->post('/add', 'App\Controllers\Api\UserPinController:addPin');
        $app->get('/{id}', 'App\Controllers\Api\UserPinController:getPinId');
        $app->get('/{id}/delete', 'App\Controllers\Api\UserPinController:softdelete');
        $app->get('/{id}/restore', 'App\Controllers\Api\UserPinController:restore');
        $app->post('/edit', 'App\Controllers\Api\UserPinController:putPin');
    });
    $app->group('/donation-news', function () use ($app, $container){
        $app->get('/list', 'App\Controllers\Api\DonationNewsController:getDonation');
        $app->post('/add', 'App\Controllers\Api\DonationNewsController:addDonationNews');
        $app->get('/{id}', 'App\Controllers\Api\DonationNewsController:getDonationNewsId');
        $app->get('/{id}/delete', 'App\Controllers\Api\DonationNewsController:remove');
        $app->post('/{id}/edit', 'App\Controllers\Api\DonationNewsController:putDonation');
    });
});
