<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $hours = floor($this->duration / 3600);
        $mins = floor(($this->duration - ($hours * 3600)) / 60);
        $secs = floor(($this->duration - ($hours * 3600)) - ($mins * 60));

        if ($hours < 10) {
            $hours = '0' . $hours;
        }

        if ($mins < 10) {
            $mins = '0' . $mins;
        }

        if ($secs < 10) {
            $secs = '0' . $secs;
        }

        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'author'        => $this->author,
            'created'       => $this->created,
            'filename'      => $this->filename,
            'duration'      => $hours . ':' . $mins . ':' . $secs,
            'thumbnail'     => $this->thumbnail,
        ];
    }
}
