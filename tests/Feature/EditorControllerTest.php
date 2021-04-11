<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assert JSON Structure of Editors Collection Resource
     *
     * @return void
     */
    public function testListEditors()
    {
        $this->seed();

        $this->post(route('editor.list', ['uuid' => 56964879]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'role',
                    ],
                ],
            ]);
    }

    /**
     * Assert Failed to list editors collection if no uuid is passed
     *
     * @return void
     */
    public function testListEditorsNoUuid()
    {
        $this->seed();

        $this->post(route('editor.list', []))
            ->assertStatus(403);
    }

    /**
     * Assert JSON Structure of Editors Resource
     *
     * @return void
     */
    public function testFetchEditor()
    {
        $this->seed();

        $this->post(route('editor.show', [
            'uuid' => 56964879,
            'id' => 4928541,
        ]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'role',
                ],
            ]);
    }

    /**
     * Assert Failed to fetch editors resource if no uuid is passed
     *
     * @return void
     */
    public function testFetchEditorNoUuid()
    {
        $this->seed();

        $this->post(route('editor.show', ['id' => 4928541]))
            ->assertStatus(403);
    }

    /**
     * Assert Not Found when ID is invalid
     *
     * @return void
     */
    public function testFetchEditorInvalidId()
    {
        $this->seed();

        $this->post(route('editor.show', [
            'uuid'  => 56964879,
            'id'    => 4928,
        ]))
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Assert JSON Structure of Current Editors Resource
     *
     * @return void
     */
    public function testFetchCurrentEditor()
    {
        $this->seed();

        $this->post(route('editor.me', ['uuid' => 56964879]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'role',
                ],
            ]);
    }

    /**
     * Assert Failed to fetch current editors resource if no uuid is passed
     *
     * @return void
     */
    public function testFetchCurrentEditorNoUuid()
    {
        $this->seed();

        $this->post(route('editor.me', []))
            ->assertStatus(403);
    }

    /**
     * Asssert Created on new Editor
     *
     * @return void
     */
    public function testCreateEditor()
    {
        $this->seed();
        $editor = [
            'uuid'      => 56964879,
            'id'        => 43242267,
            'name'      => 'Senshudo',
            'role_id'   => 2,
        ];

        $this->post(route('editor.store', $editor))
            ->assertCreated()
            ->assertJson([
                'data'  => [
                    'id'        => $editor['id'],
                    'name'      => $editor['name'],
                    'role'      => [
                        'name'          =>  'Editor',
                        'permissions'   =>  [
                            'List Videos',
                            'Edit Videos',
                            'Can Download',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Assert Success on Editor Update
     *
     * @return void
     */
    public function testUpdateEditor()
    {
        $this->seed();

        $editor = [
            'uuid'      => 56964879,
            'id'        => 4928541,
            'name'      => 'SweptSquash2',
            'role_id'   => 3,
        ];

        $this->put(route('editor.update', $editor))
            ->assertSuccessful()
            ->assertJson([
                'data'  => [
                    'id'    => $editor['id'],
                    'name'  => $editor['name'],
                    'role'  => [
                        'name'          => 'User',
                        'permissions'   => [
                            'List Videos',
                            'Can Download',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Assert Success on Editor Deletion
     *
     * @return void
     */
    public function testDeleteEditor()
    {
        $this->seed();

        $editor = [
            'uuid'      => 56964879,
            'id'        => 4928541,
        ];

        $this->delete(route('editor.delete', $editor))
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
            ]);
    }

    /**
     * Assert List Roles
     *
     * @return void
     */
    public function testListRoles()
    {
        $this->seed();

        $this->post(route('editor.roles'), ['uuid' => 56964879])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data'  => [
                    '*' => [
                        'id',
                        'name',
                        'permissions',
                    ],
                ],
            ]);
    }
}
