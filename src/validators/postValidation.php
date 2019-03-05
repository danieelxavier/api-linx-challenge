<?php

namespace Api\Validators;
use Validation\Validation;

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 3/4/19
 * Time: 11:17 PM
 */

class PostValidation
{
    public static function createValidationSchema(){
        return  Validation::arr()->keys([
            'userId' => Validation::number()->integer()->defaultValue(-1),
            'title' => Validation::string()->required(),
            'body' => Validation::string()->required(),
            'author' => UserValidation::createValidationSchema()
        ]);
    }

}