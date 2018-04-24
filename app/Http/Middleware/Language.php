<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->header('Accept-Language');

        if($lang && $lang == 'ar'){
            App::setLocale($lang);
        }else{
            App::setLocale('en');
        }

        return $next($request);
    }
}
