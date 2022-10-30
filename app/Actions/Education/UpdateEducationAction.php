<?php

namespace App\Actions\Education;

use App\Models\Education;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateEducationAction
{
    public function __invoke(Request $request)
    {
        $startDate = Carbon::createFromDate($request->input('start_date.year'), $request->input('start_date.month'))->startOfMonth();
        $endDate = $request->input('is_present') ? null : Carbon::createFromDate($request->input('end_date.year'), $request->input('end_date.month'))->startOfMonth();

        Education::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'resume_id' => $request->input('resume_id'),
                'school' => $request->input('school'),
                'qualification' => $request->input('qualification'),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_present' => $request->input('is_present'),
                'city' => $request->input('city'),
                'description' => $request->input('description'),
            ]
        );
    }
}