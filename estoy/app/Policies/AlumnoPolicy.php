<?php

namespace App\Policies;

use App\Alumno;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlumnoPolicy
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
     * @param  \App\Alumno  $alumno
     * @return mixed
     */
    public function view(User $user, Alumno $alumno)
    {

        if ($user->hasRole('directivo')) { return true; }
        return $user->docentes->cursos->contains($alumno->curso);
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
     * @param  \App\Alumno  $alumno
     * @return mixed
     */
    public function update(User $user, Alumno $alumno)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Alumno  $alumno
     * @return mixed
     */
    public function delete(User $user, Alumno $alumno)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Alumno  $alumno
     * @return mixed
     */
    public function restore(User $user, Alumno $alumno)
    {
        return $user->hasRole('directivo');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Alumno  $alumno
     * @return mixed
     */
    public function forceDelete(User $user, Alumno $alumno)
    {
        return $user->hasRole('directivo');
    }
}
