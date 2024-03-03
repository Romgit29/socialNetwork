<?php

namespace App\Policies;

use App\Models\ProfileData;
use App\Models\User;

class ProfileDataPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProfileData $profileData): bool
    {
        return $user->id == $profileData->user_id;
    }
}
