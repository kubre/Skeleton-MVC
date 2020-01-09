<?php

namespace Core;

/**
 * Class is responsible for creating responses easily
 */
class ResponseFactory {

    public static function view($config, $template, $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader($config['view_path']);
        $twig = new \Twig\Environment($loader, [
            'cache' => false
            // 'cache' => $config['view_cache_path']
        ]);

        $asset = new \Twig\TwigFunction('asset', function ($path = '') use($config) {
            return $config['base_url'].'/'.$config['assets_path'].'/'.$path;
        });

        $twig->addFunction($asset);

        $response = new Response($twig->render($template, $data), [
            'Content-Type'=> 'text/html'
        ], 200);
        return $response;
    }

    public static function json($data, $options = 0,$depth = 512)
    {
        $response = new Response(json_encode($data, $options, $depth), [
            'Content-Type'=> 'text/json'
        ], 200);
        return $response;
    }
}