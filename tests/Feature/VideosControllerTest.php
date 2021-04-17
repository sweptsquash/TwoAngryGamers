<?php

namespace Tests\Feature;

use App\Models\Videos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function seedVideos()
    {
        $videos = [
            [
                'title' => 'The Wizard ',
                'author' => 'EndersDane',
                'filename' => '[2016_06_03 15_35_55] The Wizard by EndersDane-DarkInventiveOstrichVoteYea.mp4',
                'created' => '2016-06-03 15:35:55',
                'thumbnail' => 'the-wizard-2016-06-03-153555-thumbnail.jpg',
            ],
            [
                'title' => 'I BLESS THE EGG DOWN IN RUSTICA ',
                'author' => 'EndersDane',
                'filename' => '[2016_06_06 15_37_09] I BLESS THE EGG DOWN IN RUSTICA by EndersDane-TawdryManlyClipsdadSmoocherZ.mp4',
                'created' => '2016-06-06 15:37:09',
                'thumbnail' => 'i-bless-the-egg-down-in-rustica-2016-06-06-153709-thumbnail.jpg',
            ],
            [
                'title' => 'INDIE HORROR QUEST Part XVICVI - Full badger ',
                'author' => 'Daruth505',
                'filename' => '[2016_06_09 01_30_48] INDIE HORROR QUEST Part XVICVI - Full badger by Daruth505-SecretiveSteamyClipzPeanutButterJellyTime.mp4',
                'created' => '2016-06-09 01:30:48',
                'thumbnail' => 'indie-horror-quest-part-xvicvi-full-badger-2016-06-09-013048-thumbnail.jpg',
            ],
            [
                'title' => 'Dead By Egglight ',
                'author' => 'Stabbies',
                'filename' => '[2016_06_17 13_51_57] Dead By Egglight by Stabbies-BoringFineMetalBCouch.mp4',
                'created' => '2016-06-17 13:51:57',
                'thumbnail' => 'dead-by-egglight-2016-06-17-135157-thumbnail.jpg',
            ],
        ];

        foreach ($videos as $video) {
            Videos::factory()->create($video);
        }
    }

    public function mockVideoFile()
    {
        $vid = fopen(base_path() . '/media/videos/[2016_06_03 15_35_55] The Wizard by EndersDane-DarkInventiveOstrichVoteYea.mp4', 'w');
        fclose($vid);

        $thumb = fopen(base_path() . '/public_html/images/thumbnails/the-wizard-2016-06-03-153555-thumbnail.jpg', 'w');
        fclose($thumb);
    }

    /**
     * Assert JSON Structure of Videos Collection Resource
     *
     * @return void
     */
    public function testListVideos()
    {
        $this->seed();
        $this->seedVideos();

        $this->post(route('videos.list'), ['uuid' => 56964879])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'created',
                        'filename',
                        'thumbnail',
                    ],
                ],
            ]);
    }

    /**
     * Assert JSON Structure of Filtered Videos Collection Resource
     *
     * @return void
     */
    public function testListVideosWithFilters()
    {
        $this->seed();
        $this->seedVideos();

        $this->post(route('videos.list', ['filter[created:after]' => '2016-06-03', 'filter[created:before]' => '2016-06-10']), ['uuid' => 56964879])
            ->assertSuccessful()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'created',
                        'filename',
                        'thumbnail',
                    ],
                ],
            ]);
    }

    /**
     * Assert Failed to list video collection if no uuid is passed
     *
     * @return void
     */
    public function testListVideosNoUuid()
    {
        $this->seed();
        $this->seedVideos();

        $this->post(route('videos.list', []))
            ->assertStatus(403);
    }

    /**
     * Assert JSON Structure of Videos Resource
     *
     * @return void
     */
    public function testShowVideos()
    {
        $this->seed();
        $this->seedVideos();

        $this->post(route('videos.show', [
            'uuid' => 56964879,
            'id' => 1,
        ]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'  => [
                    'id',
                    'title',
                    'author',
                    'created',
                    'filename',
                    'thumbnail',
                ],
            ]);
    }

    /**
     * Assert Failed to list video if no uuid is passed
     *
     * @return void
     */
    public function testShowVideosNoUuid()
    {
        $this->seed();
        $this->seedVideos();

        $this->post(route('videos.show', ['id' => 1]))
            ->assertStatus(403);
    }

    /**
     * Assert Success on Video Deletion
     *
     * @return void
     */
    public function testDeleteVideo()
    {
        $this->seed();
        $this->seedVideos();
        $this->mockVideoFile();

        $video = [
            'uuid'  => 56964879,
            'id'    => 1,
        ];

        $this->delete(route('videos.delete', $video))
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
            ]);
    }
}
