<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 3/1/19
 * Time: 7:25 PM
 */


namespace Api\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Api\Utils\Constants;

class PostsController extends BaseController
{

    function getAllPosts(Request $request, Response $response) {

        try{
            // Request posts from jsonplaceholder
            $resultPosts = self::makeRequest($response, Constants::METHOD_GET, Constants::URL_GET_POSTS);

            if ($resultPosts->getStatusCode() !== Constants::SUCCESS_STATUS) {
                return $resultPosts;
            }

            $allPostsArray = json_decode($resultPosts->getBody());

            // Load promises arrays to async request for all users and comments
            $promisesUsers = array();
            $promisesComments = array();

            foreach ($allPostsArray as $value){

                //promises for users request. Repeated users are ignored
                if (!array_key_exists($value->userId, $promisesUsers)){
                    $client = new Client(['base_uri' => Constants::URL_BASE_IP]);
                    $promisesUsers[$value->userId] = $client->getAsync('/users/'.$value->userId);
                }

                //promises for comments request
                $client = new Client(['base_uri' => Constants::URL_BASE_IP]);
                $promisesComments[$value->id] = $client->getAsync('/comments', [
                    'query' => ['postId' => $value->id]
                ]);
            }

            //request promises for users
            $resultsUsers = Promise\settle($promisesUsers)->wait();

            //request promises for comments
            $resultsComments = Promise\settle($promisesComments)->wait();

            //insert respective user object in posts objects. Remove 'userId' attribute from posts objects
            foreach ($allPostsArray as &$value){

                $resUser = $resultsUsers[$value->userId]['value'];

                if ($resUser->getStatusCode() === 200){
                    $value->author = json_decode($resUser->getBody());
                    unset($value->userId);
                }

            }

            //insert respective comment array in posts objects.
            foreach($promisesComments as $key => $url) {
                $comments = json_decode($resultsComments[$key]['value']->getBody());

                $allPostsArray[$comments[0]->postId-1]->comments = $comments;

            }

            $res = $response->withStatus(Constants::SUCCESS_STATUS)
                ->withHeader('content-type', 'application/json')
                ->write(json_encode(array_values($allPostsArray)));

            return $res;

        }catch (\Exception $e){

            $error = json_decode($e->getMessage());

            return $response->withStatus($error->code)
                ->withHeader('Content-Type', 'application/json')
                ->write($e->getMessage());
        }

    }



    function getPost(Request $request, Response $response) {

        try{
            //Load params from route
            $route = $request->getAttribute('route');
            $postId = $route->getArgument('id');

            //Request for post by id
            $resultPosts = self::makeRequest($response, Constants::METHOD_GET, Constants::URL_GET_POSTS.'/'.$postId);

            if ($resultPosts->getStatusCode() !== Constants::SUCCESS_STATUS){
                return $resultPosts;
            }

            $postObj = json_decode($resultPosts->getBody());


            //Request for post's user and insert in post object
            $resultUser = self::makeRequest($response, Constants::METHOD_GET, Constants::URL_GET_USER.'/'.$postObj->userId);

            if ($resultUser->getStatusCode() !== Constants::SUCCESS_STATUS){
                return $resultUser;
            }

            $postObj->author = json_decode($resultUser->getBody());
            unset($postObj->userId);

            //Request for post's comments and insert in post object
            $resultComments = self::makeRequest($response, Constants::METHOD_GET, Constants::URL_GET_COMMENTS.'/'.$postObj->userId, [
                'query' => ['postId' => $postObj->id]
            ]);

            if ($resultComments->getStatusCode() !== Constants::SUCCESS_STATUS){
                return $resultComments;
            }

            $postObj->comments = json_decode($resultComments->getBody());


            $res = $response->withStatus(Constants::SUCCESS_STATUS)
                ->withHeader('content-type', 'application/json')
                ->write(json_encode($postObj));

            return $res;

        }catch (\Exception $e){

            $error = json_decode($e->getMessage());

            return $response->withStatus($error->code)
                ->withHeader('Content-Type', 'application/json')
                ->write($e->getMessage());
        }

    }

    function createPost(Request $request, Response $response) {

        try{
            $body = $request->getParsedBody();

            //check if userId and author object are null. Only once can be null
            if ($body['userId'] === null && $body['author'] === null){
                $error =  array('message'=> "Error: you must to inform the author of post. Inform value to 'userId' for an existing user, or inform 'author' object for a new user",
                    'error'=>true,
                    'status'=> Constants::UNPROCESSABLE_ENTITY_STATUS);

                $res = $response->withStatus($error['status'])
                    ->withHeader('content-type', 'application/json')
                    ->write(json_encode($error));

                return $res;
            }


            //if is a new user, the userId is null. Then, the new user is registred
            if ($body['userId'] === null){

                /*
                 *  Here are make a POST request to register the new user
                 *
               *****  $resultInsertUser = self::makeRequest( $response, Constants::METHOD_POST, Constants::URL_POST_USERS, $body['author']); *****  //callling POST request
                 *
                 *  it is assumed that result bring the user object registered, with id.
                 *
                 *  Then, the new id can be used to create a new post
                 */

                $body['userId'] = 250; // the new id is attributed to userId. The number attributed is only an example
            }


            /*
                 *  Now are make a POST request for register a new post
                 *
               *****  $resultInsertUser = self::makeRequest( $response, Constants::METHOD_POST, Constants::URL_POST_POSTS, [
               *****   'userId' => $body['userId'],
               *****   'title' => $body['title'],
               *****   'body' => $body['body']
               *****  ]);
                 *
                 *  if everything goes well, the post is registred and the code receive a sucess response.
                 *  if the userId is non-existent or invalid, an error message is returned
                 *
                 */


            //For this example, we will make a success response

            $sucessResult = ['error' => false,
                'status' => Constants::SUCCESS_STATUS,
                'body' => 'Post registered successfully'];

            $res = $response->withStatus($sucessResult['status'])
                ->withHeader('content-type', 'application/json')
                ->write(json_encode($sucessResult));

            return $res;

        }catch (\Exception $e){

            $error = json_decode($e->getMessage());

            return $response->withStatus($error->code)
                ->withHeader('Content-Type', 'application/json')
                ->write($e->getMessage());
        }



    }


}

