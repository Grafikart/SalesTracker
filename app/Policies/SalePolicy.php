<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Carbon\CarbonImmutable;

class SalePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function cancel(User $user, Sale $sale)
    {
        return $sale->author === $user->username && $sale->created_at->gte(CarbonImmutable::now()->subMinute());
    }
}
