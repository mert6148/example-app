<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware to read `lang` query parameter or session value and set application locale.
 * Also persists selected locale in session.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->get('lang');
        if ($lang) {
            // sanitize simple two-letter code
            $lang = substr($lang, 0, 2);
            session(['app_locale' => $lang]);
        } elseif (session()->has('app_locale')) {
            $lang = session('app_locale');
        }

        if ($lang) {
            app()->setLocale($lang);
        }

        return $next($request);
    }
}
