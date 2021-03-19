<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EditorResource;
use App\Models\Editors;
use Inertia\Inertia;

class EditorController extends Controller
{
    public function show($id)
    {
        return new EditorResource(Editors::where('id', '=', $id));
    }

    public function editorLogin()
    {
        return Inertia::render('Editor/Login');
    }

    public function editorDenied()
    {
        return Inertia::render('Editor/Denied');
    }

    public function editorIndex()
    {
        return Inertia::render('Editor/List');
    }
}
