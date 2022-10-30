<?php

namespace App\Actions\Resume;

use App\Actions\Education\UpdateEducationAction;
use App\Actions\Education\DeleteEducationAction;
use App\Actions\Experience\DeleteExperienceAction;
use App\Actions\Experience\UpdateExperienceAction;
use App\Actions\PersonalDetail\UpdatePersonalDetailAction;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateResumeAction
{
    public function __invoke(Request $request, Resume $resume)
    {
        DB::transaction(function() use($request, $resume) {
            $resume->update([
                'name' => $request->input('name') ?? $resume->name
            ]);

            (new UpdatePersonalDetailAction)($request, $resume->personalDetail);

            foreach($request->input('experiences') as $experience) {
                (new DeleteExperienceAction)($request, $resume);
                (new UpdateExperienceAction)(new Request($experience + ['resume_id' => $resume->id]));
            }

            foreach($request->input('educations') as $education) {
                (new DeleteEducationAction)($request, $resume);
                (new UpdateEducationAction)(new Request($education + ['resume_id' => $resume->id]));
            }
        });
    }
}