<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEditorRequest;
use App\Http\Requests\DeleteEditorRequest;
use App\Http\Requests\FetchEditorRequest;
use App\Http\Requests\ListEditorRequest;
use App\Http\Requests\ListEditorRolesRequest;
use App\Http\Requests\UpdateEditorRequest;
use App\Http\Resources\EditorCollectionResource;
use App\Http\Resources\EditorResource;
use App\Http\Resources\RoleCollectionResource;
use App\Models\Editors;
use App\Models\Roles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class EditorController extends Controller
{
    /**
     * List All Editors
     *
     * @param Request $request
     *
     * @return EditorCollectionResource
     */
    public function index(ListEditorRequest $request)
    {
        return new EditorCollectionResource(Editors::paginate());
    }

    /**
     * Fetch A Specific Editor
     *
     * @param Request $request
     * @param string $id
     *
     * @return EditorResource|JsonResponse
     */
    public function show(FetchEditorRequest $request, string $id)
    {
        try {
            $editor = Editors::where('id', $id)->firstOrFail();

            return new EditorResource($editor);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Can not find the editor.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Fetch Current Editors Information
     *
     * @param Request $request
     *
     * @return EditorResource
     */
    public function me(FetchEditorRequest $request)
    {
        $uuid = $request->input('uuid');

        $editor = Editors::where('id', $uuid)->first();

        return new EditorResource($editor);
    }

    /**
     * Create A New Editor
     *
     * @param CreateEditorRequest $request
     *
     * @return EditorResource
     */
    public function store(CreateEditorRequest $request)
    {
        $editor = Editors::factory()->create([
            'id'        => $request->input('id'),
            'name'      => $request->input('name'),
            'role_id'   => $request->input('role_id'),
        ]);

        return new EditorResource($editor);
    }

    /**
     * Update An Existing Editor
     *
     * @param string $id
     * @param UpdateEditorRequest $request
     *
     * @return EditorResource|JsonResponse
     */
    public function update($id, UpdateEditorRequest $request)
    {
        try {
            $editor = Editors::where('id', $id)->firstOrFail();

            $editor->update([
                'name'      => $request->input('name'),
                'role_id'   => $request->input('role_id'),
            ]);

            return new EditorResource($editor);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Can not find the editor.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete An Existing Editor
     *
     * @param string $id
     * @param DeleteEditorRequest $request
     *
     * @return JsonResponse
     */
    public function delete($id, DeleteEditorRequest $request)
    {
        try {
            Editors::where('id', $id)
                ->firstOrFail()
                ->delete();

            return new JsonResponse([
                'status' => 'success',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Can not find the editor.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * List All Editor Roles
     *
     * @param ListEditorRolesRequest $request
     *
     * @return RoleCollectionResource
     */
    public function roles(ListEditorRolesRequest $request)
    {
        return new RoleCollectionResource(Roles::all());
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
