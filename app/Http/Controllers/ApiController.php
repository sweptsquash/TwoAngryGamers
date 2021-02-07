<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleCollectionResource;
use App\Models\Schedule;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class ApiController extends Controller
{
    /**
     * Schedule List
     *
     * @return ScheduleCollectionResource
     */
    public function scheduleList()
    {
        return new ScheduleCollectionResource(Schedule::paginate());
    }

    /**
     * Next Scheduled Stream
     *
     * @return json
     */
    public function scheduleNext()
    {
        $schedule = Schedule::all();
        $nextStream = $streams = [];

        $now = Carbon::now();

        foreach ($schedule as $event) {
            $dayOfWeek = $event->start->format('l');
            $time = explode(':', $event->start->format('H:i:s'));

            $start = new Carbon(
                (new DateTime())
                    ->setTimestamp(strtotime($dayOfWeek, $now->getTimestamp()))
                    ->setTime($time[0], $time[1], $time[2]),
                new DateTimeZone('UTC')
            );

            $end = clone $start;
            $end->addSeconds($event->duration);

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
}
