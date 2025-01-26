<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Carbon created_at
 */
class Sale extends Model
{

    use SoftDeletes;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected $fillable = [
        'author'
    ];

}
