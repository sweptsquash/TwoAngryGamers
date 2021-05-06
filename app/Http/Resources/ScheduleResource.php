<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $now       = Carbon::now();
        $dayOfWeek = $this->start->format('l');
        $time      = explode(':', $this->start->format('H:i:s'));

        $start = new Carbon(
            (new DateTime())
                ->setTimestamp(strtotime($dayOfWeek, $now->getTimestamp()))
                ->setTime($time[0], $time[1], $time[2]),
            new DateTimeZone('UTC')
        );

        $end = clone $start;
        $end->addSeconds($this->duration);

        if ($now->getTimestamp() > $end->getTimestamp()) {
            $start = new Carbon(
                (new DateTime())
                    ->setTimestamp(strtotime('next ' . $dayOfWeek, $now->getTimestamp()))
                    ->setTime($time[0], $time[1], $time[2]),
                new DateTimeZone('UTC')
            );

            $end = clone $start;
            $end->addSeconds($this->duration);
        }

        return [
            'name'          => $this->name,
            'start'         => $start->format('d/m/Y H:i:s'),
            'end'           => $end->format('d/m/Y H:i:s'),
            'description'   => $this->description,
            'special'       => $this->special,
        ];
    }
}
