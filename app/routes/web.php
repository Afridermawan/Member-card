<?php

$app->get('/mc-admin', 'App\Controllers\Web\UserController:getLoginAsAdmin')->setName('login.admin');
$app->post('/mc-admin', 'App\Controllers\Web\UserController:loginAsAdmin')->setName('login.admin'); 

$app->group('', function () use ($app, $container){
    $app->group('/admin', function () use ($app, $container){
        $app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('home.admin');
        $app->get('/logout', 'App\Controllers\Web\UserController:logout');
        $app->get('/article', 'App\Controllers\Web\ArticleController:getArticle')->setName('list.article');
        $app->get('/article/add', 'App\Controllers\Web\ArticleController:getAddArticle')->setName('list.article');
        $app->post('/article/add', 'App\Controllers\Web\ArticleController:postArticle')->setName('add.article');
        $app->get('/article/{id}/update', 'App\Controllers\Web\ArticleController:getEditArticle')->setName('edit.article');
        $app->post('/article/{id}/update', 'App\Controllers\Web\ArticleController:putArticle')->setName('edit.article');
        $app->get('/article/{id}/delete', 'App\Controllers\Web\ArticleController:destroy');
        $app->get('/article/{slug}', 'App\Controllers\Web\ArticleController:getArticleDetailSlug');
        $app->get('/article/{id}/detail', 'App\Controllers\Web\ArticleController:getArticleDetailId');
        $app->get('/article/{id}/comment', 'App\Controllers\Web\ArticleController:getComment');
        $app->get('/article/{id}/comment/admin', 'App\Controllers\Web\ArticleController:getCommentByAdmin');
        $app->get('/comment/article', 'App\Controllers\Web\ArticleController:getArticleComment')->setName('get.comment');
        $app->post('/article/{id}/comment', 'App\Controllers\Web\ArticleController:postComment')->setName('add.comment');
        $app->get('/category', 'App\Controllers\Web\ArticleController:category');
        $app->get('/category/article', 'App\Controllers\Web\ArticleController:getCategory');
        $app->get('/category/article/{id}', 'App\Controllers\Web\ArticleController:getCategoryDetail');
        $app->get('/category_article', 'App\Controllers\Web\ArticleController:getCategoryArticle');
        $app->group('/user', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\UserController:getUser')->setName('list.user');
            $app->get('/{id}/detail', 'App\Controllers\Web\UserController:getUserDetail');
            $app->get('/{id}/delete', 'App\Controllers\Web\UserController:delete');
            $app->get('/{id}/restore', 'App\Controllers\Web\UserController:restore');
            $app->get('/{id}/edit', 'App\Controllers\Web\UserController:getPutUser');
            $app->post('/{id}/edit', 'App\Controllers\Web\UserController:putUser')->setName('edit.user');
            $app->put('/edit/image', 'App\Controllers\Web\FileSystemController:upload');
        });
        $app->group('/produk', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\ProdukController:getProduk')->setName('list.produk');
            $app->get('/{slug}/detail', 'App\Controllers\Web\ProdukController:getProdukDetailSlug');
            $app->get('/{id}/find', 'App\Controllers\Web\ProdukController:getProdukDetailId');
            $app->get('/add', 'App\Controllers\Web\ProdukController:getAddProduk');
            $app->post('/add', 'App\Controllers\Web\ProdukController:addProduk')->setName('add.produk');
            $app->get('/{id}/delete', 'App\Controllers\Web\ProdukController:softdelete');
            $app->get('/{id}/restore', 'App\Controllers\Web\ProdukController:restore');
            $app->get('/{id}/edit', 'App\Controllers\Web\ProdukController:getEditProduk');
            $app->post('/{id}/edit', 'App\Controllers\Web\ProdukController:putProduk')->setName('edit.produk');
            $app->get('/list/items', 'App\Controllers\Web\ProdukController:listItems')->setName('list.items.produk');
            $app->get('/{id}/remove/produk/item', 'App\Controllers\Web\ProdukController:removeBuyerProduct');
            $app->post('/{id}/edit/buy', 'App\Controllers\Web\ProdukController:editBuy')
                ->setName('edit.pembelian.produk');
        });
        $app->group('/event', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\EventController:getEvent')->setName('list.event');
            $app->get('/{slug}/detail', 'App\Controllers\Web\EventController:getEventDetailSlug');
            $app->get('/{id}/find', 'App\Controllers\Web\EventController:getEventDetailId');
            $app->get('/add', 'App\Controllers\Web\EventController:getAddEvent');
            $app->post('/add', 'App\Controllers\Web\EventController:addEvent')->setName('add.event');
            $app->get('/{id}/delete', 'App\Controllers\Web\EventController:softdelete')->setName('delete.event');
            $app->get('/{id}/restore', 'App\Controllers\Web\EventController:restore')->setName('restore.event');
            $app->get('/{id}/edit', 'App\Controllers\Web\EventController:getEditEvent');
            $app->post('/{id}/edit', 'App\Controllers\Web\EventController:putEvent')->setName('edit.event');
            $app->get('/list/items', 'App\Controllers\Web\EventController:listItems')->setName('list.items.event');
            $app->get('/{id}/remove/event/item', 'App\Controllers\Web\EventController:removeBuyerEvent')
                ->setName('remove.buyer.event');
            $app->post('/{id}/edit/buy', 'App\Controllers\Web\EventController:editBuy')
                ->setName('edit.pembelian.event');
        });
        $app->group('/pin', function () use ($app, $container){
            // $app->post('/add', 'App\Controllers\Web\UserPinController:AddPin')->setName('add.pin');
            $app->get('/list', 'App\Controllers\Web\UserPinController:getPin')->setName('list.pin');
            $app->get('/{id}', 'App\Controllers\Web\UserPinController:getPinId');
            $app->get('/{id}/delete', 'App\Controllers\Web\UserPinController:delete');
            $app->get('/{id}/restore', 'App\Controllers\Web\UserPinController:restore');
            // $app->post('/{id}/edit', 'App\Controllers\Web\UserPinController:putPin')->setName('edit.pin');
        });
        $app->group('/donation-news', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\DonationNewsController:getDonation')->setName('list.donasi');
            $app->get('/add', 'App\Controllers\Web\DonationNewsController:getDonationNews');
            $app->post('/add', 'App\Controllers\Web\DonationNewsController:addDonationNews')->setName('add.donasi');
            $app->get('/{id}', 'App\Controllers\Web\DonationNewsController:getPinId');
            $app->get('/{id}/delete', 'App\Controllers\Web\DonationNewsController:remove');
            $app->get('/{id}/edit', 'App\Controllers\Web\DonationNewsController:geteditDonationNews');
            $app->post('/{id}/edit', 'App\Controllers\Web\DonationNewsController:putDonationNews')
                ->setName('edit.donasi');
        });
    });
})->add(new \App\Middlewares\AdminMiddleware($container));


    $app->get('/activateaccount/{token}', 'App\Controllers\Web\UserController:activateaccount');
    $app->get('/', 'App\Controllers\Web\UserController:getLogin')->setName('login');
    $app->post('/', 'App\Controllers\Web\UserController:login')->setName('post.login');
    $app->get('/form/reset', 'App\Controllers\Web\UserController:get')->setName('get.form');
    $app->get('/auth/signup', 'App\Controllers\Web\UserController:getAddUser');
    $app->post('/auth/signup', 'App\Controllers\Web\UserController:register')->setName('register');
    $app->post('/reset', 'App\Controllers\Web\UserController:forgotPassword')->setName('password.reset');
    $app->get('/password/reset/{token}', 'App\Controllers\Web\UserController:getResetPassword')->setName('get.reset');
    $app->get('/recovery', 'App\Controllers\Web\UserController:getRecoveryPage')->setName('recovery.password');
    $app->post('/password/reset', 'App\Controllers\Web\UserController:resetPassword')->setName('post.reset');
    $app->get('/404', 'App\Controllers\Web\HomeController:notFound')->setName('not.found');
$app->group('', function () use ($app, $container){
    $app->group('/web', function () use ($app, $container){
        $app->get('/home', 'App\Controllers\Web\HomeController:home')->setName('home.user');
        $app->get('/logout', 'App\Controllers\Web\UserController:logout');
        $app->get('/article', 'App\Controllers\Web\ArticleController:getArticle')->setName('list.article.user');
        $app->get('/article/{slug}', 'App\Controllers\Web\ArticleController:getArticleDetailSlug');
        $app->get('/article/{id}/detail', 'App\Controllers\Web\ArticleController:getArticleDetailId')
            ->setName('detail.article');
        $app->get('/article/{id}/comment', 'App\Controllers\Web\ArticleController:getComment');
        $app->post('/article/{id}/comment', 'App\Controllers\Web\ArticleController:postComment');
        $app->get('/comment/article', 'App\Controllers\Web\ArticleController:getArticleComment');
        $app->get('/category/article', 'App\Controllers\Web\ArticleController:getCategory');
        $app->get('/category/article/{id}', 'App\Controllers\Web\ArticleController:getCategoryDetail');
        $app->get('/category_article', 'App\Controllers\Web\ArticleController:getCategoryArticle');
        $app->group('/user', function () use ($app, $container){
            $app->get('/profile', 'App\Controllers\Web\UserController:profile')->setName('profile');
            $app->get('/edit/{id}/profile', 'App\Controllers\Web\UserController:getProfile')->setName('edit.profile');
            $app->post('/edit/{id}/profile', 'App\Controllers\Web\UserController:editProfile')->setName('edit.profile');
            $app->get('/{id}/detail', 'App\Controllers\Web\UserController:getUserDetail');
            $app->post('/change/image', 'App\Controllers\Web\UserController:postImage');
        });
        $app->group('/produk', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\ProdukController:getProduk')->setName('list.produk');
            $app->get('/{slug}/detail', 'App\Controllers\Web\ProdukController:getProdukDetailSlug');
            $app->get('/{id}/find', 'App\Controllers\Web\ProdukController:getProdukDetailId');
            $app->get('/{id}/buy', 'App\Controllers\Web\ProdukController:getBuyProduk')->setName('beli.produk');
            $app->post('/{id}/buy', 'App\Controllers\Web\ProdukController:buy')->setName('beli.produk');
            $app->get('/list/items', 'App\Controllers\Web\ProdukController:listItems')->setName('list.items.produk');
            $app->get('/bayar', 'App\Controllers\Web\ProdukController:bayar')->setName('bayar');
            $app->get('/{id}/list/items', 'App\Controllers\Web\ProdukController:findItems')->setName('detail.pembelian.produk');
            $app->post('/{id}/edit/buy', 'App\Controllers\Web\ProdukController:editBuy')
                ->setName('edit.pembelian.produk');
        });
        $app->group('/event', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\EventController:getEvent')->setName('list.event');
            $app->get('/{slug}/detail', 'App\Controllers\Web\EventController:getEventDetailSlug');
            $app->get('/{id}/find', 'App\Controllers\Web\EventController:getEventDetailId');
            $app->get('/{id}/buy', 'App\Controllers\Web\EventController:getBuyEvent')->setName('beli.event');
            $app->post('/{id}/buy', 'App\Controllers\Web\EventController:buy')->setName('beli.event');
            $app->get('/list/items', 'App\Controllers\Web\EventController:listItems')->setName('list.items.event');
            $app->get('/bayar', 'App\Controllers\Web\EventController:bayar')->setName('bayar');
            $app->get('/{id}/list/items', 'App\Controllers\Web\EventController:findItems')->setName('detail.daftar.event');
            $app->post('/{id}/edit/buy', 'App\Controllers\Web\EventController:editBuy')
                ->setName('edit.pembelian.event');
        });
        $app->group('/pin', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\UserPinController:getPin')->setName('list.pin');
            $app->get('/add', 'App\Controllers\Web\UserPinController:getAddPin')->setName('add.pin');
            $app->post('/add', 'App\Controllers\Web\UserPinController:addPin')->setName('add.pin');
            $app->get('/edit', 'App\Controllers\Web\UserPinController:getEditPin')->setName('edit.pin');
            $app->post('/edit', 'App\Controllers\Web\UserPinController:putPin')->setName('edit.pin');
            $app->get('/{id}', 'App\Controllers\Web\UserPinController:getPinId');
            $app->post('/check/password', 'App\Controllers\Web\UserPinController:checkPassword');
        });
        $app->group('/donation-news', function () use ($app, $container){
            $app->get('/list', 'App\Controllers\Web\DonationNewsController:getDonation')->setName('list.donasi');
            $app->get('/{id}', 'App\Controllers\Web\DonationNewsController:getDonationDetailId');
        });
    });
})->add(new \App\Middlewares\AuthMiddleware($container));
