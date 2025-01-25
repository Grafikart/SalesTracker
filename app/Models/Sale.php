<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon created_at
 */
class Sale extends Model
{

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected $fillable = [
        'author'
    ];

}
