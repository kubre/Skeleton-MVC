<?php

namespace App\Controllers;

use Core\Request;

class SiteController {

    public function index(Request $request)
    {
        return view('index', ['name' => 'Skeleton']);
    }

    public function api(Request $request)
    {
        return json(['name' => $request->query('name')]);
    }

    public function page404(Request $request)
    {
        return view('page404')
            ->withStatus(404);
    }
}