<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/28/19
 * Time: 10:07 PM
 */


$app->get('/posts', 'PostsController:getAllPosts');
$app->get('/posts/{id}', 'PostsController:getPost');
$app->post('/posts', 'PostsController:createPost')->add(new CreatePostMiddleware());
//$app->run();
