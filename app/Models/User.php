<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User
{

    use Authorizable;

    public function __construct(public string $username){

    }

}
