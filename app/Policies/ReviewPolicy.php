<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ReviewPolicy
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
    public function view(User $user, Review $review): bool
    {
        //

        if($user->role == 'admin'){
            return true;
        }elseif($user->id == $review->user_id){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,Order $order): bool
    {
        //

        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        //

        return $user->id == $review->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        //

        if($user->role == 'admin'){
            return true;
        }elseif($user->id == $review->user_id){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Review $review): bool
    {
        //

        if($user->role == 'admin'){
            return true;
        }elseif($user->id == $review->user_id){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Review $review): bool
    {
        //

        if($user->role == 'admin'){
            return true;
        }elseif($user->id == $review->user_id){
            return true;
        }else{
            return false;
        }
    }
}