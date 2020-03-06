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
    /**
     * TODO: Basic foundation completed more functions and better structure to add
     */
    public static function validate($data = [], $rules = [])
    {
        $errors= [];
        foreach($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $params = explode(':', $rule);
                $rule = array_shift($params);
                $errors[$field][$rule] = Validator::$rule([
                    'data' => $data,
                    'field' => $field,
                    'params' => $params
                ]);
            }
        }
        return $errors;
    }

    public static function required($args)
    {
        return !empty($args['data'][$args['field']]);
    }

    public static function string($args)
    {
        return is_string($args['data'][$args['field']]);
    }
}
