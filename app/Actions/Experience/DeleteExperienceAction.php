<?php

namespace App\Actions\Experience;

use App\Models\Resume;
use Illuminate\Http\Request;

class DeleteExperienceAction
{
    public function __invoke(Request $request, Resume $resume)
    {
        if($request->has('experiences')) {
            $resume->experiences()
                ->whereNotIn('id', array_filter(array_map(
                    fn($val) => isset($val['id']) ? $val['id'] : null,
                    $request->input('experiences')
                )))
                ->delete();
        } else {
            $resume->experiences()->delete();
        }
    }
}