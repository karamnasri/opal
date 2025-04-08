<?php

namespace App\Http\Middleware;

use App\Enums\TokenAbilityEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessTokenAbility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if the user has the correct ability for the access token
        if (! $user->tokenCan(TokenAbilityEnum::REFRESH_TOKEN->value)) {
            return response()->json(['status' => false, 'message' => 'Access token is invalid or expired.'], 403);
        }

        return $next($request);
    }
}
