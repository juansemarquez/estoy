<?php

namespace App\Policies;

use App\Comunicacion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComunicacionPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comunicacion  $comunicacion
     * @return mixed
     */
    public function view(User $user, Comunicacion $comunicacion)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comunicacion  $comunicacion
     * @return mixed
     */
    public function update(User $user, Comunicacion $comunicacion)
    {
        if ($user->hasRole('directivo')) { return true; }
        return $user->docentes->id === $comunicacion->docente->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comunicacion  $comunicacion
     * @return mixed
     */
    public function delete(User $user, Comunicacion $comunicacion)
    {
        if ($user->hasRole('directivo')) { return true; }
        return $user->docentes === $comunicacion->docente;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comunicacion  $comunicacion
     * @return mixed
     */
    public function restore(User $user, Comunicacion $comunicacion)
    {
        if ($user->hasRole('directivo')) { return true; }
        return $user->docentes === $comunicacion->docente;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comunicacion  $comunicacion
     * @return mixed
     */
    public function forceDelete(User $user, Comunicacion $comunicacion)
    {
        if ($user->hasRole('directivo')) { return true; }
        return $user->docentes === $comunicacion->docente;
    }
}
