<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchVideosRequest;
use App\Http\Requests\ListVideosRequest;
use App\Http\Resources\VideosCollectionResource;
use App\Http\Resources\VideosResource;
use App\Models\Videos;
use Illuminate\Http\JsonResponse;

class VideosController extends Controller
{
    public function index(ListVideosRequest $request)
    {
        return new VideosCollectionResource(Videos::paginate());
    }

    public function show(FetchVideosRequest $request, string $id)
    {
        $video = Videos::where('id', $id)->first();

        if (! empty($video)) {
            return new VideosResource($video);
        } else {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], 400);
        }
    }

    public function update()
    {
        // TODO: Update Method
    }

    public function delete()
    {
        // TODO: Delete Method
    }
}
