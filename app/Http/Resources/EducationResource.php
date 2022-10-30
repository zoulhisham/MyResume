<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $startDate =  (new Carbon($this->start_date));
        $endDate =  (new Carbon($this->end_date));

        return [
            'id' => $this->id,
            'school' => $this->school,
            'qualification' => $this->qualification,
            'start_date' => [
                'month' => $startDate->format('m'),
                'year' => $startDate->format('Y')
            ] ,
            'start_date_display' => $startDate->format('M Y'),
            'end_date' => $this->is_present ? null :[
                'month' => $endDate->format('m'),
                'year' => $endDate->format('Y')
            ],
            'end_date_display' => $endDate->format('M Y'),
            'is_present' => $this->is_present ? true : false,
            'city' => $this->city,
            'description' => $this->description
        ];
    }
}
