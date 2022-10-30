<?php

namespace App\Actions\Education;

use App\Models\Resume;
use Illuminate\Http\Request;

class DeleteEducationAction
{
    public function __invoke(Request $request, Resume $resume)
    {
        if($request->has('educations')) {
            $resume->educations()
                ->whereNotIn('id', array_filter(array_map(
                    fn($val) => isset($val['id']) ? $val['id'] : null,
                    $request->input('educations')
                )))
                ->delete();
        } else {
            $resume->educations()->delete();
        }
    }
}