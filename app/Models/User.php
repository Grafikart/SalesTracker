<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User implements Authenticatable
{

    use Authorizable, \Illuminate\Auth\Authenticatable;

    public function __construct(public string $username){
    }

    public function getKeyName()
    {
        return 'username';
    }

    public function getRememberToken()
    {
        return $this->username;
    }

    public function getAuthPassword()
    {
        return $this->username;
    }

}
