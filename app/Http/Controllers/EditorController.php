<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EditorResource;
use App\Models\Editors;

class EditorController extends Controller
{
    public function show($id)
    {
        return new EditorResource(Editors::where('id', '=', $id));
    }
}
