<?php
/**
 * MIT License
 * Copyright (c) 2020 Vaibhav Kubre
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
        return $_SESSION[$key] ?? null;
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
