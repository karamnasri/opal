<?php

namespace App\Http\Middleware;

use App\Enums\SocialProvidersEnum;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class SocialProviderMiddleware
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $provider = $request->route('provider');
        $isValidProvider = collect(SocialProvidersEnum::cases())
            ->contains(fn(SocialProvidersEnum $enum) => $enum->value === $provider);

        if (!$isValidProvider) {
            $this->errorResponse("Unsupported provider: {$provider}", 400);
        }

        $request->merge(['provider' => SocialProvidersEnum::from($provider)->value]);
        return $next($request);
    }
}
