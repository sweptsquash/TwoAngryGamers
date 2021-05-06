<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleCollectionResource;
use App\Models\Schedule;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Google_Client;
use Google_Service_YouTube;

class ScheduleController extends Controller
{
    /**
     * Schedule List.
     *
     * @return ScheduleCollectionResource
     */
    public function scheduleList()
    {
        return new ScheduleCollectionResource(Schedule::paginate());
    }

    /**
     * Next Scheduled Stream.
     *
     * @return json
     */
    public function scheduleNext()
    {
        $schedule   = Schedule::all();
        $nextStream = $streams = [];

        $now = Carbon::now();

        foreach ($schedule as $event) {
            $dayOfWeek = $event->start->format('l');
            $time      = explode(':', $event->start->format('H:i:s'));

            $start = new Carbon(
                (new DateTime())
                    ->setTimestamp(strtotime($dayOfWeek, $now->getTimestamp()))
                    ->setTime($time[0], $time[1], $time[2]),
                new DateTimeZone('UTC')
            );

            $end = clone $start;
            $end->addSeconds($event->duration);

            if ($now->getTimestamp() > $end->getTimestamp()) {
                $start = new Carbon(
                    (new DateTime())
                        ->setTimestamp(strtotime('next ' . $dayOfWeek, $now->getTimestamp()))
                        ->setTime($time[0], $time[1], $time[2]),
                    new DateTimeZone('UTC')
                );

                $end = clone $start;
                $end->addSeconds($event->duration);
            }

            $streams[$start->getTimestamp()] = [
                'name'          => $event->name,
                'interval'      => $event->interval,
                'start'         => $start->getTimestamp(),
                'end'           => $end->getTimestamp(),
                'duration'      => $event->duration,
                'description'   => $event->description,
                'special'       => $event->special,
            ];
        }

        ksort($streams, SORT_NUMERIC);

        $nextStream = $streams[array_key_first($streams)];

        return response()->json($nextStream);
    }

    public function fetchYouTube()
    {
        $devKey = config('services.youtube.key');

        if (! empty($devKey)) {
            $videos = [
                'videos' => [],
            ];

            $client = new Google_Client();
            $client->setApplicationName('TwoAngryGamers');
            $client->setDeveloperKey($devKey);

            $service = new Google_Service_YouTube($client);

            $playlistResponse = $service->playlistItems->listPlaylistItems(
                'snippet',
                [
                    'playlistId' => 'PLw5InzJSby6H3htBAOMt_H0MtJGpIvTW8',
                    'maxResults' => 21,
                ]
            );

            if (! empty($playlistResponse)) {
                foreach ($playlistResponse as $video) {
                    $videos['videos'][] = [
                        'id'            => $video->id,
                        'title'         => $video->snippet->title,
                        'thumbnail'     => $video->snippet->thumbnails->medium->url,
                        'url'           => 'https://www.youtube.com/watch?v=' . $video->snippet->resourceId->videoId . '&utm_source=tagwebsite&utm_medium=vodsection&utm_campaign=youtube_growth',
                    ];
                }
            }

            return response()->json($videos);
        } else {
            return response()->json(['status' => 'error', 'message' => 'YouTube Developer Key Missing.'], 400);
        }
    }
}
