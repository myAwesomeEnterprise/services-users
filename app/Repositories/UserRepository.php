<?php


namespace App\Repositories;


use App\Entities\User;

class UserRepository extends Repository
{
    /**
     * @return User
     */
    public function getModel()
    {
        return new User();
    }

    /**
     * @param User $user
     * @param int $days
     * @return bool
     */
    public function ban(User $user, int $days = 0)
    {
        $user->ban = true;
        $user->banned_until = $days > 0 ? now()->addDays($days) : null;

        return $user->save();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function unBan(User $user)
    {
        $user->ban = false;
        $user->banned_until = null;

        return $user->save();
    }
}
