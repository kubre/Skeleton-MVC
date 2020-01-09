<?php

use Core\Skeleton;
use Core\ResponseFactory;

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        return ResponseFactory::view(app()->getConfig(), $view, $data);
    }
}

if (!function_exists('json')) {
    function json($data, $options = 0, $depth = 512)
    {
        return ResponseFactory::json($data, $options, $depth);
    }
}

if (!function_exists('session_on_demand')) {
    function session_on_demand()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}

if (!function_exists('session')) {
    function session($key, ...$value)
    {
        session_on_demand();
        if (1 == count($value)) {
            $_SESSION[$key] = $value[0];
        }
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
}

if (!function_exists('auth')) {
    /**
     * Get or Set user object in session
     *
     * @param \App\Models\User ...$user
     * @return \App\Models\User
     */
    function auth(...$user)
    {
        if (1 == count($user)) {
            session('user_auth', $user[0]) ;
        }
        $model = 'App\\Models\\'.app()->getConfig()['user_model'];
        return session('user_auth') ?? new $model;
    }
}

if (!function_exists('app')) {
    function app()
    {
        return Skeleton::getInstance();
    }
}
