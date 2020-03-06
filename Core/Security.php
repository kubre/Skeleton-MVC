<?php

/**
 * MIT License
 * Copyright (c) [2020] [Vaibhav Kubre]
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

namespace Core;

class Security
{
    /**
     * Simple XSS clean function
     * 
     * @param array|string $field Field to be cleaned
     * 
     * @return array|string cleaned data 
     */
    public static function xssClean($field)
    {
        if (is_array($field)) return array_map(Security::class . '::xssClean', $field);
        return htmlspecialchars($field, ENT_QUOTES);
    }


    /**
     * Get/Generate CSRF token and store in $_SESSION['_token'] field
     */
    public static function getCsrfToken()
    {
        if (
            is_null(session('_token')) || (time() - session('_token_time')) / 60 >= 10
        ) {
            session('_token', bin2hex(random_bytes(32)));
            session('_token_time', time());
        }
        return session('_token');
    }


    /**
     * Check whether CSRF token is valid or not
     * 
     * @param string $token Token to be matched with one in session
     * 
     * @return bool
     */
    public static function checkCsrfToken($token)
    {
        return hash_equals(session('_token'), $token) && (time() - session('_token_time')) / 60 < 10;
    }
}
