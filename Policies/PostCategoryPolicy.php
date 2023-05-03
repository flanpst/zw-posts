<?php

namespace Modules\Posts\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Posts\Models\PostCategory;

class PostCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAbility('post-categoria-listar');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PostCategory $postCategory)
    {
        return $user->hasAbility('post-categoria-visualizar');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAbility('post-categoria-cadastrar');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->hasAbility('post-categoria-editar');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PostCategory $postCategory)
    {
        return $user->hasAbility('post-categoria-excluir');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PostCategory $postCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PostCategory $postCategory)
    {
        //
    }
}
