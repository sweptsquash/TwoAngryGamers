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
        return Inertia::render('About');
    }

    public function subperks()
    {
        return Inertia::render('SubPerks');
    }
}
