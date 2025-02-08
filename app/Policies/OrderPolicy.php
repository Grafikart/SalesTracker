<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Carbon\CarbonImmutable;

class OrderPolicy
{

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Order $sale)
    {
        return $sale->user_id === $user->id;
    }

    public function restore(User $user, Order $sale)
    {
        return $this->delete($user, $sale);
    }
}
