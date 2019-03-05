<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 3/3/19
 * Time: 3:53 PM
 */

namespace Api\Utils;

class Constants
{

    //URLS
    const URL_BASE_IP = 'https://jsonplaceholder.typicode.com/';
    const URL_GET_USER = 'https://jsonplaceholder.typicode.com/users';
    const URL_GET_POSTS = 'https://jsonplaceholder.typicode.com/posts';
    const URL_POST_USERS = 'https://jsonplaceholder.typicode.com/users';
    const URL_POST_POSTS= 'https://jsonplaceholder.typicode.com/posts';
    const URL_GET_COMMENTS = 'https://jsonplaceholder.typicode.com/comments';


    //HTTP STATUS
    const SUCCESS_STATUS = 200;
    const FORBIDDEN_STATUS = 403;
    const NOT_FOUND_STATUS = 404;
    const UNPROCESSABLE_ENTITY_STATUS = 422;
    const INTERNAL_ERROR_STATUS = 500;


    //HTTP METHOD
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';


}