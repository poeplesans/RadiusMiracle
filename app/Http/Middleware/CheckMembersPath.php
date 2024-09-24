<?php

namespace App\Http\Middleware;

use App\Helpers\MenuHelper;
use Closure;
use Illuminate\Http\Request;

class CheckMembersPath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $arraymenus = MenuHelper::getDynamicMenu();
        $accesslist = $arraymenus['accesslist'];
        $currentPath = '/' . $request->path(); // Contoh: '/members', '/profile', dll.
        $isAuthorized = false;

        foreach ($accesslist as $subArray) {
            // Periksa jika $subArray adalah array dan memiliki elemen
            if (is_array($subArray) && !empty($subArray)) {
                $deepestValue = $subArray[0]; // Ambil nilai pertama dari sub-array

                // Cek apakah path cocok secara persis atau menggunakan wildcard `/*`
                if ($deepestValue == $currentPath || str_starts_with($currentPath, rtrim($deepestValue, '/*'))) {
                    $isAuthorized = true;
                    break;
                }
            }
        }

        // Jika path tidak ada di accesslist, redirect ke /notauth
        if (!$isAuthorized) {
            return redirect('/notauth');
        }

        // Jika path ditemukan di accesslist, lanjutkan request
        return $next($request);
    }
}
