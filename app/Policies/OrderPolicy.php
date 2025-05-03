<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Order $order)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isFarmer() && $order->user_id === $user->id) {
            return true;
        }

        if ($user->isSupplier()) {
            $supplierProductIds = $user->products()->pluck('id')->toArray();
            foreach ($order->items as $item) {
                if (in_array($item->product_id, $supplierProductIds)) {
                    return true;
                }
            }
        }

        return false;
    }

      {
                    return true;
                }
            }
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->isFarmer();
    }

    public function update(User $user, Order $order)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Order $order)
    {
        return $user->isAdmin();
    }
}
