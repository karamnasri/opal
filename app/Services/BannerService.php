<?php

namespace App\Services;

use App\Models\Banner;

class BannerService
{

    public function getAll()
    {
        return Banner::all();
    }
}
