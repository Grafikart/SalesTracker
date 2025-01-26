<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Carbon\CarbonImmutable;

class SalePolicy
{

    public function cancel(User $user, Sale $sale)
    {
        return $sale->author === $user->username && $sale->created_at->gte(CarbonImmutable::now()->subMinute());
    }

    public function delete(User $user, Sale $sale)
    {
        return $sale->author === $user->username;
    }

    public function restore(User $user, Sale $sale)
    {
        return $this->delete($user, $sale);
    }
}
