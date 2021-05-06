<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteVideoRequest;
use App\Http\Requests\FetchVideosRequest;
use App\Http\Requests\ListVideosRequest;
use App\Http\Requests\UpdateVideosRequest;
use App\Http\Resources\VideosCollectionResource;
use App\Http\Resources\VideosResource;
use App\Models\Videos;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Iman\Streamer\VideoStreamer;
use Str;
use ZipArchive;

class VideosController extends Controller
{
    /**
     * List All Videos.
     *
     * @param Request $request
     *
     * @return VideosCollectionResource
     */
    public function index(ListVideosRequest $request)
    {
        try {
            $videos = Videos::where(function ($query) use ($request) {
                if ($request->has('filter')) {
                    $filters = $request->get('filter');

                    if (array_key_exists('created:after', $filters)) {
                        $query->where(
                            'created',
                            '>=',
                            Carbon::createFromFormat('Y-m-d', $filters['created:after'])->setTime(0, 0, 0)
                        );
                    }

                    if (array_key_exists('created:before', $filters)) {
                        $query->where(
                            'created',
                            '<=',
                            Carbon::createFromFormat('Y-m-d', $filters['created:before'])->setTime(0, 0, 0)
                        );
                    }
                }
            });

            return new VideosCollectionResource($videos->orderBy('created', 'DESC')->paginate());
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'No videos not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Fetch A Specific Video.
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
     * Update A Specific Videos Details.
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
     * Delete A Specific Video from the Database and Filesystem.
     *
     * @return void
     */
    public function delete($id, DeleteVideoRequest $request)
    {
        try {
            $video = Videos::where('id', $id)
                ->firstOrFail();

            unlink(base_path() . '/public_html/images/thumbnails/' . $video->thumbnail);
            unlink(base_path() . '/media/videos/' . $video->filename);

            $video->delete();

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
     * Fetch Thumbnail.
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
     * Download Video.
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

    /**
     * Compress and Download Collection of Videos.
     *
     * @return Response|JsonResponse
     */
    public function downloadCollection(Request $request)
    {
        try {
            if ($request->has('ids')) {
                $ids = explode(',', $request->ids);

                $videos = Videos::whereIn('id', $ids)->get();

                if ($videos->isNotEmpty()) {
                    $videoFiles = [];
                    $zipFile    = 'TAG-Collection-' . date('Y-m-d-H-i-s') . '.zip';

                    foreach ($videos as $video) {
                        $videoFiles[] = $video->filename;
                    }

                    $zip = new ZipArchive();

                    $zip->open(
                        base_path() . '/media/tmp/' . $zipFile,
                        ZipArchive::CREATE
                    );

                    foreach ($videoFiles as $file) {
                        $zip->addFile(base_path() . '/media/videos/' . $file, $file);
                    }

                    $zip->close();

                    return response()->download(
                        base_path() . '/media/tmp/' . $zipFile,
                        $zipFile,
                        ['Content-Type' => 'application/zip']
                    );
                } else {
                    throw new \Exception('Videos not found.');
                }
            } else {
                throw new \Exception('No ids passed');
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Stream Video File.
     *
     * @return VideoStreamer|JsonResponse
     */
    public function streamVideo(string $id)
    {
        try {
            $video = Videos::where('id', $id)
                ->firstOrFail();

            return VideoStreamer::streamFile(base_path() . '/media/videos/' . $video->filename);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status'    => 'error',
                'message'   => 'Video not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
