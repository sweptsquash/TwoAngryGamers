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
use Str;

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
    public function show(string $id, FetchVideosRequest $request)
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
    public function update($id, UpdateVideosRequest $request)
    {
        try {
            $video = Videos::where('id', $id)->firstOrFail();

            $video->update([
                'title'     => $request->input('title'),
                'author'    => $request->input('author'),
            ]);

            return new VideosResource($video);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete A Specific Video from the Database and Filesystem
     *
     * @param DeleteVideoRequest $request
     *
     * @return void
     */
    public function delete($id, DeleteVideoRequest $request)
    {
        try {
            Videos::where('id', $id)
                ->firstOrFail()
                ->delete();

            // TODO: Delete Video & Thumbnail

            return new JsonResponse([
                'status' => 'success',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Fetch Thumbnail
     *
     * @param string $id
     *
     * @return Response|JsonResponse
     */
    public function thumbnail(string $id)
    {
        try {
            $video = Videos::where('id', $id)
                ->firstOrFail();

            return response()->file(
                base_path() . '/public_html/images/thumbnails/' . $video->thumbnail,
                ['Content-Type' => 'image/jpeg']
            );
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Download Video
     *
     * @param string $id
     *
     * @return Response|JsonResponse
     */
    public function download(string $id)
    {
        try {
            $video = Videos::where('id', $id)
                ->firstOrFail();

            return response()->download(
                base_path() . '/media/videos/' . $video->filename,
                Str::slug($video->title . '-' . $video->created) . '.mp4',
                ['Content-Type' => 'video/mp4']
            );
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function downloadCollection()
    {
        // TODO: Build ZIP download
    }
}
