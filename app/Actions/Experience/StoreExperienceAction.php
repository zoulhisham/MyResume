<?php

namespace App\Actions\Experience;

use App\Models\Resume;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreExperienceAction
{
    public function __invoke(Request $request, Resume $resume): void
    {
        $startDate = Carbon::createFromDate($request->input('start_date.year'), $request->input('start_date.month'))->startOfMonth();
        $endDate = $request->input('is_present') ? null : Carbon::createFromDate($request->input('end_date.year'), $request->input('end_date.month'))->startOfMonth();

        $resume->experiences()->create([
            'position' => $request->input('position'),
            'company_name' => $request->input('company_name'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_present' => $request->input('is_present'),
            'city' => $request->input('city'),
            'description' => $request->input('description')
        ]);
    }
}