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

        $this->post('/api/editor', ['uuid' => 4928541])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'permissions',
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

        $this->post('/api/editor', [])
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

        $this->post('/api/editor/56964879', ['uuid' => 4928541])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'permissions',
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

        $this->post('/api/editor/56964879', [])
            ->assertStatus(403);
    }

    /**
     * Assert JSON Structure of Current Editors Resource
     *
     * @return void
     */
    public function testFetchCurrentEditor()
    {
        $this->seed();

        $this->post('/api/editor/me', ['uuid' => 4928541])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'permissions',
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

        $this->post('/api/editor/me', [])
            ->assertStatus(403);
    }
}
