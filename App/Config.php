<?php

namespace App;

class Config
{
    /**
     * Get Applcation Config
     *
     * @return array configs
     */
    public static function getConfig()
    {
        return [
            /**
             * Base Url of application
             * ex:
             * example.com/ => '' // Leave empty
             * example.com/myapp => 'myapp'
             * example.com/myapp/anotherapp => 'myapp/anotherapp'
             */
            'base_url' => 'oneklick/public',


            /**
             * Assets directory path relative to base_url
             */
            'assets_path' => 'assets',

            /**
             * Which namespace controllers of application resides
             * Deafault is App\Controllers
             */
            'namespace' => 'App\\Controllers',


            /**
             * Which controller will be used for simple /action urls
             * Deafult is Site
             * ex:
             * example.com/about :
             *      will call about method on Site Controller.
             * example.com/about/1/edit :
             *      will be same as above but 1 and edit are params to function.
             */
            'default_controller' => 'Site',


            /**
             * What action should / route trigger i.e. your landing site
             * By deafult it's index method in Deafult Controller(SiteController)
             */
            'action_index' => 'index',
            

            /**
             * If unknown page is requested (i.e. 404)
             * By deafult it's page404 method in Deafult Controller(SiteController)
             */
            'action_404' => 'page404',
            

            /**
             * Path where twig view templates are stored
             */
            'view_path' => __DIR__ . '/Views/',
            
            
            /**
             * Path where twig to store compiled templates
             */
            'view_cache_path' => dirname(__DIR__) . '/storage/views/',


            /**
             * Which superglobals to while making app instance
             */
            'superglobals' => [
                'get' => $_GET,
                'post' => $_POST,
                'files' => $_FILES,
                'server' => $_SERVER,
                'cookie' => $_COOKIE,
                'request' => $_REQUEST
            ],


            /**
             * Default user model to use
             * default is App\Models\User
             */
            'user_model' => 'User',
        ];
    }
}
