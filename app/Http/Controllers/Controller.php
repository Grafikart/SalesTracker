<?php

namespace App\Http\Controllers;

use App\AuthService;
use Illuminate\Auth\Access\AuthorizationException;

abstract class Controller
{


    public function authorize(string $name, mixed $arg)
    {
        if (AuthService::getUser()->cant($name, $arg)) {
            throw new AuthorizationException(sprintf("Vous n'avez pas la permission de faire l'action %s", $name));
        }
    }

}
