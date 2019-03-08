<?php

namespace App\Policies;

use App\Models\Jobcard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobcardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the user.
     *
     * @param User             $authenticatedUser
     * @param \App\Models\Jobcard $jobcard *
     * @return mixed
     *
     * @internal param \App\Models\User $user
     */
    public function view(User $authenticatedUser, Jobcard $jobcard) {
        if ($authenticatedUser->can('view jobcards')) {
            return true;
        }

        if ($authenticatedUser->can('view own jobcards')) {
            return $authenticatedUser->id === $jobcard->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can update the jobcard.
     *
     * @param User             $authenticatedUser
     * @param \App\Models\Jobcard $jobcard *
     * @return mixed
     *
     * @internal param \App\Models\User $user
     */
    public function update(User $authenticatedUser, Jobcard $jobcard) {

        return true;
    }

    /**
     * Determine whether the user can delete the jobcard.
     *
     * @param User             $authenticatedUser
     * @param \App\Models\Jobcard $jobcard *
     * @return mixed
     *
     * @internal param \App\Models\User $user
     */
    public function delete(User $authenticatedUser, Jobcard $jobcard) {
        if ($authenticatedUser->can('delete jobcards')) {
            return true;
        }

        if ($authenticatedUser->can('delete own jobcards')) {
            return $authenticatedUser->id === $jobcard->user_id;
        }

        return false;
    }
}
