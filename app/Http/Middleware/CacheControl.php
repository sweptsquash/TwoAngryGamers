<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
{
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        $response->setCache(['public' => true, 'max_age' => 60, 's_maxage' => 60]);

        // Remove all cookies
        foreach ($response->headers->getCookies() as $cookie) {
            $response->headers->removeCookie($cookie->getName());
        }

        return $response;
    }
}
