<?php

namespace App\Http\Resources;

use App\Http\Resources\ScheduleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ScheduleCollectionResource extends ResourceCollection
{
    /**
     * The resoruce that this resource collects
     *
     * @var string
     */
    public $collects = ScheduleResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
