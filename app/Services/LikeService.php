<?php

namespace App\Services;

use App\DTOs\LikeDTO;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function toggle(LikeDTO $dto)
    {
        $design = Design::find($dto->design_id);
        $user = Auth::user();

        $liked = $user->likedDesigns()->where('designs.id', $dto->design_id)->exists();

        if ($liked) {
            $design->likedByUsers()->detach($user->id);
            $dto->removeLike();
        } else {
            $design->likedByUsers()->attach($user->id);
            $dto->addLike();
        }
    }
}
