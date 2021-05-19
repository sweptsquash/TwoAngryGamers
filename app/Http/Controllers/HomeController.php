<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function about()
    {
        return Inertia::render('About')
            ->withViewData(['meta' => ['title' => 'About Us']]);
    }

    public function subperks()
    {
        return Inertia::render('SubPerks')
            ->withViewData(['meta' => ['title' => 'Sub Perks']]);
    }
}
