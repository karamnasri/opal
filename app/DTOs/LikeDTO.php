<?php

namespace App\DTOs;

use App\Traits\DtoRequestTrait;

class LikeDTO
{
    use DtoRequestTrait;
    public int $design_id;
    public bool $like;
    public string $message;

    public function addLike()
    {
        $this->like = true;
        $this->message = "Like added";
    }
    public function removeLike()
    {
        $this->like = false;
        $this->message = "Like removed";
    }
}
