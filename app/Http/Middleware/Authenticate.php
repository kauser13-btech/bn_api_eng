<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }
        if (Auth::user()->status != 1) {
            echo 'This Account Has Been Suspended.';
            exit;
            die();
        }

        $current_uri = request()->segments();
        if (!Auth::user()->two_factor_secret && $current_uri[1] != 'dashboard' && $current_uri[0] != 'ewmgl') {
            echo 'Please, Enable Enable Two-Factor Authentication.';
            exit;
            die();
        }

        /**
         * user type and role management.
         */
        $routeArray = app('request')->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $action) = explode('@', $controllerAction);

        // echo $controller;exit;

        switch ($controller) {
            case 'NewsController':
                $edition = ($request->get('edition') == 'magazine') ? 'print' : $request->get('edition');
                if ($edition != Auth::user()->type && Auth::user()->type != 'all' && !($edition == 'multimedia' && Auth::user()->type == 'online')) {
                    return Redirect::to('admin/error403')->send();
                    exit;
                    die();
                }
                break;
                // Online User
            case 'GalleryController':
            case 'BreakingNewsController':
            case 'ReportController':
                if (Auth::user()->type != 'online' && Auth::user()->type != 'all') {
                    return Redirect::to('admin/error403')->send();
                }
                break;
                // Print User
            case 'PrintSettingsController':
            case 'AstrologyController':
            case 'ScreenController':
            case 'PaperController':
            case 'PoolController':
                if (Auth::user()->type != 'print' && Auth::user()->type != 'all') {
                    return Redirect::to('admin/error403')->send();
                }
                break;
                // Developer
            case 'AdsController':
            case 'UserController':
                if (Auth::user()->role != 'developer') {
                    return Redirect::to('admin/error403')->send();
                }
                break;
        }


        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
