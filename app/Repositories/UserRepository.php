<?php


namespace App\Repositories;

use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
     * @param string $password
     * @param User $user
     * @return bool
     */
    public function checkPassword(string $password, User $user): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * @param User $user
     * @param int $days
     * @return bool
     */
    public function ban(User $user, int $days = 0): bool
    {
        $user->ban = true;
        $user->banned_until = $days > 0 ? now()->addDays($days) : null;

        return $user->save();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function unBan(User $user): bool
    {
        $user->ban = false;
        $user->banned_until = null;

        return $user->save();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isBanned(User $user): bool
    {
        if ($user->ban) {
            if ($user->banned_until === null) {
                return true;
            }

            return $user->banned_until->gte(Carbon::now());
        }

        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function verify(User $user): bool
    {
        $user->verified_at = Carbon::now();
        return $user->save();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function unVerify(User $user): bool
    {
        $user->verified_at = null;
        return $user->save();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isVerified(User $user): bool
    {
        $required = config('service.user.verification.required');

        return $required && (is_null($user->verified_at) || $user->verified_at->gte(Carbon::now()));
    }
}
