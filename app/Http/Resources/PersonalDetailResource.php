<?php

namespace App\Http\Resources;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PersonalDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'gender_name' => Gender::from($this->gender)->name,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'country_name' => $this->country->name,
            'age' => $this->getAge($this->birth_date),
            'profile_image' => $this->profile_image,
            'profile_image_url' => $this->profile_image ? Storage::url($this->profile_image) : null
        ];
    }

    private function getAge($birthDate)
    {
        $today = Carbon::now();
        $date = $today->diff($birthDate);

        return $this->getDisplay($date, 'year');
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
