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

class Validator
{
    public static function validate($data = [], $rules = [], $config = \App\Config::class)
    {
        $errors = [];
        foreach ($rules as $field => $fieldRules) {
            $name = ucwords(str_replace("_", " ", $field));
            foreach ($fieldRules as $rule) {
                $params = explode(':', $rule);
                $rule = array_shift($params);
                if(!Validator::$rule($data, $field, $params)) {
                    $errors[$field][$rule] = $config::getMessage($rule, $name, $params);
                }
            }
        }
        return $errors;
    }

    /* Validation functions */
    private static function required($data, $field, $params)
    {
        return !empty($data[$field]);
    }

    private static function string($data, $field, $params)
    {
        return filter_var($data[$field], FILTER_SANITIZE_STRING);
    }

    private static function digits($data, $field, $params)
    {
        $data = $data[$field];
        return is_numeric($data) && strlen($data) == $params[0];
    }

    private static function boolean($data, $field, $params)
    {
        return filter_var($data[$field], FILTER_VALIDATE_BOOLEAN) === null;
    }

    private static function confirmed($data, $field, $params)
    {
        return $data[$field] === ($data[$field . '_confirmation'] ?: null);
    }

    private static function email($data, $field, $params)
    {
        return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
    }

    private static function file($data, $field, $params)
    {
        return is_uploaded_file($data[$field]);
    }

    private static function image($data, $field, $params)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $data = $data[$field];
        $allowed = ['image/jpeg', 'image/gif', 'image/png', 'image/webp', 'image/svg+xml', 'image/bmp'];
        return is_uploaded_file($data) &&
            array_search(
                $finfo->file($data['tmp_name']),
                explode(',', $params[0]) ?: $allowed
            );
    }

    private static function date($data, $field, $params)
    {
        return strtotime($data[$field]) !== false;
    }

    private static function date_equals($data, $field, $params)
    {
        return strtotime($data[$field]) == strtotime($params[0]);
    }

    private static function date_after($data, $field, $params)
    {
        return strtotime($data[$field]) > strtotime($params[0]);
    }

    private static function date_before($data, $field, $params)
    {
        return strtotime($data[$field]) < strtotime($params[0]);
    }

    private static function different($data, $field, $params)
    {
        return $data[$field] !== $data[$params[0]];
    }

    private static function same($data, $field, $params)
    {
        return $data[$field] === $data[$params[0]];
    }

    private static function present($data, $field, $params)
    {
        return key_exists($field, $data);
    }

    private static function max($data, $field, $params)
    {
        $data = $data[$field];
        if (is_numeric($data)) return (float) $data <= $params[0];
        else if (is_array($data)) return count($data) <= $params[0];
        else if (is_uploaded_file($data)) return filesize($data) / 1024 <= $params[0];
        return strlen($data) <= $params[0];
    }

    private static function min($data, $field, $params)
    {
        $data = $data[$field];
        if (is_numeric($data)) return (float) $data >= $params[0];
        else if (is_array($data)) return count($data) >= $params[0];
        else if (is_file($data)) return filesize($data) / 1024 >= $params[0];
        return strlen($data) >= $params[0];
    }
}
