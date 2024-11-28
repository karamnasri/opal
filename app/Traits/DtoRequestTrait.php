<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait DtoRequestTrait
{
    /**
     * Dynamically set properties from validated request data.
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        $instance = new static();

        foreach ($request->validated() as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }

    /**
     * Convert DTO properties to an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
