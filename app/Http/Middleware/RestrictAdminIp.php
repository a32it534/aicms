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

        // اگر مقدار خالی باشد یا ستاره (*) باشد، همه مجاز هستند
        if (empty($allowedIps) || $allowedIps === '*') {
            return $next($request);
        }

        $ipsArray = array_map('trim', explode(',', $allowedIps));

        if (!in_array($request->ip(), $ipsArray)) {
            abort(403, 'دسترسی غیرمجاز: آی‌پی شما مجاز به ورود به بخش مدیریت نیست.');
        }

        return $next($request);
    }
}



// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// class RestrictAdminIp
// {
//     /**
//      * Handle an incoming request.
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         // دریافت لیست آی‌پی‌های مجاز از .env
//         $allowedIpsRaw = env('ADMIN_ALLOWED_IPS', '127.0.0.1,::1');
//         $allowedIps = array_filter(array_map('trim', explode(',', $allowedIpsRaw)));

//         // دریافت آی‌پی کاربر جاری
//         $clientIp = $request->ip();

//         // بررسی اینکه آیا آی‌پی کاربر در لیست مجاز وجود دارد یا خیر
//         if (!in_array($clientIp, $allowedIps)) {
//             // در صورتی که آی‌پی مجاز نبود، دسترسی مسدود می‌شود (خطای 403)
//             abort(403, 'دسترسی غیرمجاز: آی‌پی شما مجاز به ورود به بخش مدیریت نیست.');
//         }

//         return $next($request);
//     }
// }
