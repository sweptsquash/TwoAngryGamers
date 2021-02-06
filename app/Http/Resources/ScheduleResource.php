<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dayOfWeek = $this->start->format('l');
        $time = explode(':', $this->start->format('H:i:s'));

        $start = new DateTime();
        $start->setTimestamp(strtotime('next ' . $dayOfWeek));
        $start->setTime($time[0], $time[1], $time[2]);

        $end = new DateTime();

        $interval = new DateTime();
        $interval->setTimestamp(0);
        $interval->add(new \DateInterval('PT'.$this->interval.'S'));
        $intervalStamp = $interval->getTimestamp();

        $duration = new \DateTime();
        $duration->setTimestamp(0);
        $duration->add(new \DateInterval('PT'.$this->duration.'S'));
        $durationStamp = $duration->getTimestamp();

        $dif = max(0, ceil(($end->getTimestamp() - $start->getTimestamp() - $durationStamp)/$intervalStamp));
        $end->setTimestamp($start->getTimestamp() + $intervalStamp * $dif);

        return [
            'name'          => $this->name,
            'interval'      => $this->interval,
            'start'         => $start->format('Y-m-d H:i:s'),
            'end'           => $end->add(new \DateInterval('PT'.$this->duration.'S'))->format('Y-m-d H:i:s'),
            'duration'      => $this->duration,
            'description'   => $this->description,
            'special'       => $this->special,
        ];
    }
}
