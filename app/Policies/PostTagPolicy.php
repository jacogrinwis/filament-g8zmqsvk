<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\PostTag;
use Illuminate\Auth\Access\Response;

class PostTagPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            // UserRole::User,
            UserRole::Editor,
            UserRole::Admin,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostTag $post_tag): bool
    {
        if ($user->role === UserRole::Admin) return true;
        if ($user->role === UserRole::Editor) return true;

        // owners mogen hun eigen posts zien
        return $post_tag->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [
            UserRole::Editor,
            UserRole::Admin,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostTag $post_tag): bool
    {
        if ($user->role === UserRole::Admin) return true;

        if ($user->role === UserRole::Editor) {
            return true;
        }

        // gewone user mag alleen eigen posts wijzigen
        return $post_tag->user_id === $user->id;
    }

    public function updateAny(User $user): bool
    {
        return in_array($user->role, [
            UserRole::Editor,
            UserRole::Admin,
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostTag $post_tag): bool
    {
        if ($user->role === UserRole::Admin) return true;

        // editors mogen NIET verwijderen
        // users mogen alleen eigen posten verwijderen
        return $post_tag->user_id === $user->id;
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostTag $post_tag): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restoreAny(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostTag $post_tag): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }
}
