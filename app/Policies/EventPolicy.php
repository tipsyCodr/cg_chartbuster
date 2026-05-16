<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Event $event): bool
    {
        if ($event->approval_status === 'approved') {
            return true;
        }

        return $user && ($user->is_admin || $user->id === $event->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can submit
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        return $user->is_admin || ($user->id === $event->user_id && $event->approval_status === 'pending');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->is_admin || ($user->id === $event->user_id && $event->approval_status === 'pending');
    }

    /**
     * Determine whether the user can moderate events.
     */
    public function moderate(User $user): bool
    {
        return $user->is_admin;
    }
}
