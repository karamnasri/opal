<?php

namespace App\Policies;

use App\Models\Design;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DesignPolicy
{
    public function canAccessFilePath(User $user, Design $design): bool
    {
        return $user->purchases()
            ->where('design_id', $design->id)
            ->where('created_at', '>=', now()->subMonth())
            ->exists();
    }
}
