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

/**
 * Class is responsible for creating responses easily
 */
class ResponseFactory {


    /**
     * Render view with twig
     *
     * @param \Core\Config $config
     * @param string $template
     * @param array $data
     * @return Response
     */
    public static function view($config = \Core\Config::class, $template, $data = []): Response
    {
        $loader = new \Twig\Loader\FilesystemLoader($config::VIEW_PATH);
        $twig = new \Twig\Environment($loader, [
            'cache' => $config::getViewCachePath()
        ]);

        $csrfToken = new \Twig\TwigFunction('csrf_token', function () {
            return Security::getCsrfToken();
        });

        $twig->addFunction($csrfToken);

        $response = new Response($twig->render($template, $data), [
            'Content-Type'=> 'text/html'
        ], 200);
        return $response;
    }

    /**
     * Generate json response 
     *
     * @param array $data
     * @param integer $options
     * @param integer $depth
     * @return Response
     */
    public static function json($data, $options = 0,$depth = 512): Response
    {
        $response = new Response(json_encode($data, $options, $depth), [
            'Content-Type'=> 'text/json'
        ], 200);
        return $response;
    }
}