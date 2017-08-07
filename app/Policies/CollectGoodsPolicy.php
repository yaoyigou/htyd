<?php

namespace App\Policies;

use App\User;
use App\Models\CollectGoods;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectGoodsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the collectGoods.
     *
     * @param  \App\User $user
     * @param  \App\Models\CollectGoods $collectGoods
     * @return mixed
     */
    public function view(User $user, CollectGoods $collectGoods)
    {
        //
    }

    /**
     * Determine whether the user can create collectGoods.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the collectGoods.
     *
     * @param  \App\User $user
     * @param  \App\Models\CollectGoods $collectGoods
     * @return mixed
     */
    public function update(User $user, CollectGoods $collectGoods)
    {
        //
    }

    /**
     * Determine whether the user can delete the collectGoods.
     *
     * @param  \App\User $user
     * @param  \App\Models\CollectGoods $collectGoods
     * @return mixed
     */
    public function delete(User $user, CollectGoods $collectGoods)
    {
        return $user->user_id = $collectGoods->user_id;
    }
}
