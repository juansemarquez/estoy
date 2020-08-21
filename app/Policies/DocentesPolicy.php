<?php

namespace App\Policies;

use App\Docentes;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocentesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Docentes  $docentes
     * @return mixed
     */
    public function view(User $user, Docentes $docentes)
    {
        if ($user->hasRole('directivo')) { return true; }
        return $user->docentes->id === $docentes->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Docentes  $docentes
     * @return mixed
     */
    public function update(User $user, Docentes $docentes)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Docentes  $docentes
     * @return mixed
     */
    public function delete(User $user, Docentes $docentes)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Docentes  $docentes
     * @return mixed
     */
    public function restore(User $user, Docentes $docentes)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Docentes  $docentes
     * @return mixed
     */
    public function forceDelete(User $user, Docentes $docentes)
    {
        return $user->hasRole('directivo');
    }
}
