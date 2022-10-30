<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ExperienceResource extends JsonResource
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
            'position' => $this->position,
            'company_name' => $this->company_name,
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
            'description' => $this->description,
            'duration' => $this->dateDurationDisplay($this->start_date, $this->is_present ? Carbon::now() : $this->end_date)
        ];
    }

    private function dateDurationDisplay($startDate, $endDate)
    {
        $startDate = new Carbon($startDate);
        $endDate = new Carbon($endDate);

        $date = $endDate->diff($startDate);

        $year = $this->getDisplay($date, 'year');
        $month = $this->getDisplay($date, 'month');

        $duration = $year . $month;

        if(!$year && !$month) {
            $day = $this->getDisplay($date, 'day');
            $duration = $day;
        }
        
        return $duration;
    }

    private function getDisplay($date, $type)
    {
        $result = '';
        switch($type) {
            case 'day':
                $text = 'Day';
                $format = 'd';
            break;
            case 'month':
                $text = 'Month';
                $format = 'm';
            break;
            case 'year':
                $text = 'Year';
                $format = 'y';
            break;
        }

        if($date->$format) {
            if($date->$format > 1) {
                $result = $date->$format . ' ' . Str::plural($text) . ' ';
            } else {
                $result = $date->$format . " $text ";
            }
        }

        return $result;
    }
}
