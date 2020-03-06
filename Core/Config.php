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

class Config
{
    /**
     * Base Url of application
     * ex:
     * example.com/ => '' // Leave empty
     * example.com/myapp => 'myapp'
     * example.com/myapp/anotherapp => 'myapp/anotherapp'
     */
    const BASE_URL = 'Skeleton-MVC/public';
    

    /**
     * Assets directory path relative to base_url
     */
    const ASSETS_PATH = 'assets';

    /**
     * Which namespace controllers of application resides
     * Deafault is App\Controllers
     */
    const CONTROLLER_NAMESPACE = 'App\\Controllers';


    /**
     * Which controller will be used for simple /action urls
     * Deafult is Site
     * ex:
     * example.com/about :
     *      will call about method on Site Controller.
     * example.com/about/1/edit :
     *      will be same as above but 1 and edit are params to function.
     */
    const DEFAULT_CONTROLLER = 'Site';


    /**
     * What action should / route trigger i.e. your landing site
     * By deafult it's index method in Deafult Controller(SiteController)
     */
    const ACTION_INDEX = 'index';
            

    /**
     * If unknown page is requested (i.e. 404)
     * By deafult it's page404 method in Deafult Controller(SiteController)
     */
    const ACTION_404 = 'page404';
            

    /**
     * Path where twig view templates are stored
     */
    const VIEW_PATH = __DIR__ . '/Views/';
            
            
    /**
     * Path where twig to store compiled templates
     */
    public static function getViewCachePath(){ 
        return dirname(__DIR__) . '/storage/views/';
    }

    /**
     * Which superglobals to while making app instance
     */
    public static function getGlobals()
    {
        return [
                    'get' => $_GET,
                    'post' => $_POST,
                    'files' => $_FILES,
                    'server' => $_SERVER,
                    'cookie' => $_COOKIE,
                    'request' => $_REQUEST
                ];
    }


    /**
     * Default user model to use
     * default is App\Models\User
     */
    const USER_MODEL = 'User';
}
