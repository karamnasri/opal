<?php

namespace App\DTOs;

use App\Models\Design;
use App\Models\User;
use App\Traits\DtoRequestTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class LikeDTO
{
    use DtoRequestTrait;
    public int $design_id;
    public bool $like;
    public string $message;
    public Design $design;
    public User&Authenticatable $user;

    public function toggle()
    {
        $this->design->isLikedBy($this->user) ? $this->removeLike() : $this->addLike();
    }

    public function addLike()
    {
        $this->design->likers()->attach($this->user->id);
        $this->like = true;
        $this->message = "Like added";
    }
    public function removeLike()
    {
        $this->design->likers()->detach($this->user->id);
        $this->like = false;
        $this->message = "Like removed";
    }

    public function fillDTO()
    {
        $this->user = auth()->user();
        $this->design = Design::find($this->design_id);
        return $this;
    }
}
