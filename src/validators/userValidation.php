<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 3/4/19
 * Time: 11:25 PM
 */

namespace Api\Validators;


use Validation\Validation;

class UserValidation
{
    public static function createValidationSchema(){
        return  Validation::arr()->keys([
            'name' => Validation::string()->required(),
            'username' => Validation::string()->required(),
            'email' => Validation::string()->email()->required(),
            'phone' => Validation::string()->required(),
            'website' => Validation::string()->required(),
            'address' =>  Validation::arr()->keys([
                'street' => Validation::string()->required(),
                'suite' => Validation::string()->required(),
                'city' => Validation::string()->required(),
                'zipcode' => Validation::string()->required(),
                'geo' => Validation::arr()->keys([
                    'lat' => Validation::string()->required(),
                    'lng' => Validation::string()->required()
                ])->required(),
            ])->required(),
            'company' => Validation::arr()->keys([
                'name' => Validation::string()->required(),
                'catchPhrase' => Validation::string()->required(),
                'bs' => Validation::string()->required()
            ])->required()
        ])->defaultValue(json_encode("{}"));
    }
}