<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEditorRequest;
use App\Http\Requests\DeleteEditorRequest;
use App\Http\Requests\FetchEditorRequest;
use App\Http\Requests\ListEditorRequest;
use App\Http\Requests\UpdateEditorRequest;
use App\Http\Resources\EditorCollectionResource;
use App\Http\Resources\EditorResource;
use App\Models\Editors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EditorController extends Controller
{
    /**
     * List All Editors
     *
     * @param Request $request
     *
     * @return JsonResponse|EditorCollectionResource
     */
    public function index(ListEditorRequest $request)
    {
        $uuid = $request->input('uuid');

        $currentEditor = Editors::where('id', $uuid)->first();

        if (! empty($currentEditor) && $currentEditor->hasPermission('List Editors')) {
            return new EditorCollectionResource(Editors::paginate());
        } else {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Editor not found.',
            ], 400);
        }
    }

    /**
     * Fetch A Specific Editor
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse|EditorResource
     */
    public function show(FetchEditorRequest $request, string $id)
    {
        $uuid = $request->input('uuid');

        $currentEditor = Editors::where('id', $uuid)->first();

        if (! empty($currentEditor)) {
            $editor = Editors::where('id', $id)->first();

            if (! empty($editor)) {
                return new EditorResource($editor);
            } else {
                return new JsonResponse([
                    'status'    => 'error',
                    'message'   => 'Editor not found.',
                ], 400);
            }
        } else {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Current Editor not found.',
            ], 400);
        }
    }

    /**
     * Fetch Current Editors Information
     *
     * @param Request $request
     *
     * @return JsonResponse|EditorResource
     */
    public function me(FetchEditorRequest $request)
    {
        $uuid = $request->input('uuid');

        $editor = Editors::where('id', $uuid)->first();

        if (! empty($editor)) {
            return new EditorResource($editor);
        } else {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Editor not found.',
            ], 400);
        }
    }

    /**
     * Create A New Editor
     *
     * @param CreateEditorRequest $request
     *
     * @return void
     */
    public function create(CreateEditorRequest $request)
    {
        // TODO: Create method
    }

    /**
     * Update An Existing Editor
     *
     * @param UpdateEditorRequest $request
     *
     * @return void
     */
    public function update(UpdateEditorRequest $request)
    {
        // TODO: Update Method
    }

    /**
     * Delete An Existing Editor
     *
     * @param DeleteEditorRequest $request
     *
     * @return void
     */
    public function delete(DeleteEditorRequest $request)
    {
        // TODO: Delete Method
    }

    /**
     * Editor Login Page
     *
     * @return \Inertia\Response
     */
    public function editorLogin()
    {
        return Inertia::render('Editor/Login');
    }

    /**
     * Deny Access to Editor Section
     *
     * @return \Inertia\Response
     */
    public function editorDenied()
    {
        return Inertia::render('Editor/Denied');
    }

    /**
     * List Videos
     *
     * @return \Inertia\Response
     */
    public function editorIndex()
    {
        return Inertia::render('Editor/List');
    }
}
