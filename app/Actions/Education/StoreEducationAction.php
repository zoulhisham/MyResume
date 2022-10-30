<?php

namespace App\Actions\Education;

use App\Models\Resume;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreEducationAction
{
    public function __invoke(Request $request, Resume $resume)
    {
        $startDate = Carbon::createFromDate($request->input('start_date.year'), $request->input('start_date.month'))->startOfMonth();
        $endDate = $request->input('is_present') ? null : Carbon::createFromDate($request->input('end_date.year'), $request->input('end_date.month'))->startOfMonth();

        $resume->educations()->create([
            'school' => $request->input('school'),
            'qualification' => $request->input('qualification'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_present' => $request->input('is_present'),
            'city' => $request->input('city'),
            'description' => $request->input('description'),
        ]);
    }
}