<?php

namespace App\Policies;

use App\Curso;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CursoPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function view(User $user, Curso $curso)
    {
        //
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
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function update(User $user, Curso $curso)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function delete(User $user, Curso $curso)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function restore(User $user, Curso $curso)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function forceDelete(User $user, Curso $curso)
    {
        return $user->hasRole('directivo');
    }
}
