<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteVideoRequest;
use App\Http\Requests\FetchVideosRequest;
use App\Http\Requests\ListVideosRequest;
use App\Http\Requests\UpdateVideosRequest;
use App\Http\Resources\VideosCollectionResource;
use App\Http\Resources\VideosResource;
use App\Models\Videos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VideosController extends Controller
{
    /**
     * List All Videos
     *
     * @param Request $request
     *
     * @return VideosCollectionResource
     */
    public function index(ListVideosRequest $request)
    {
        return new VideosCollectionResource(Videos::paginate());
    }

    /**
     * Fetch A Specific Video
     *
     * @param FetchVideosRequest $request
     * @param string $id
     *
     * @return VideoResource|JsonResponse
     */
    public function show(FetchVideosRequest $request, string $id)
    {
        try {
            $video = Videos::where('id', $id)->firstOrFail();

            return new VideosResource($video);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update A Specific Videos Details
     *
     * @param UpdateVideosRequest $request
     *
     * @return void
     */
    public function update(UpdateVideosRequest $request)
    {
        // TODO: Update Method
    }

    /**
     * Delete A Specific Video from the Database and Filesystem
     *
     * @param DeleteVideoRequest $request
     *
     * @return void
     */
    public function delete(DeleteVideoRequest $request)
    {
        // TODO: Delete Method
    }
}
