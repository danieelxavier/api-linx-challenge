<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
use Api\Utils\Constants;
use Api\Validators\PostValidation;
use Slim\Http\Response;
use Slim\Http\Request;
use Validation\Validation;

class CreatePostMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        //validate the parameters
        $body = $request->getParsedBody();
        $validation = Validation::validate($body, PostValidation::createValidationSchema());

        //if there a error in validate, the error response is returned
        if($validation['err'] !== null){

            $msg = $validation['err'];

            $msg = str_replace("\"", "'", $msg);

            $error =  array('message'=> $msg,
                'error'=>true,
                'status'=> Constants::UNPROCESSABLE_ENTITY_STATUS);

            $res = $response->withStatus($error['status'])
                ->withHeader('content-type', 'application/json')
                ->write(json_encode($error));

            return $res;
        }

        //if parameters are OK, keep going
        $response = $next($request, $response);

        return $response;

    }

}

