<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminIp
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = env('ADMIN_ALLOWED_IPS', '*');

        if (empty($allowedIps) || $allowedIps === '*') {
            return $next($request);
        }

        $ipsArray = array_map('trim', explode(',', $allowedIps));

        if (!in_array($request->ip(), $ipsArray)) {
            abort(
                403,
                'دسترسی غیرمجاز: آی‌پی شما مجاز به ورود به بخش مدیریت نیست.'
            );
        }

        return $next($request);
    }
}
