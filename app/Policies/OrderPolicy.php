<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        //

        if($user->role == 'admin' ||  $user->role == 'service'){
            return true;
        }elseif($order->phone == $user->phone){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //

        return true;    
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        //

        return $user->role == 'admin' ||  $user->role == 'service';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        //

        if($user->role == 'admin' ||  $user->role == 'service'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        //

        return $order->phone == $user->phone;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        //

        if($user->role == 'admin' || $order->phone == $user->phone ){
            return true;
        }else{
            return false;
        }
    }
}
