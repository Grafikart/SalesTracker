<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{

    public function sale(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
