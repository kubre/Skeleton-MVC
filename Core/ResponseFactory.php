<?php

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
            'cache' => $config::VIEW_CACHE_PATH
        ]);

        // $asset = new \Twig\TwigFunction('asset', function ($path = '') use($config) {
        //     return $config::BASE_URL.'/'. $config::VIEW_PATH.'/'.$path;
        // });

        // $twig->addFunction($asset);

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