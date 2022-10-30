<?php

namespace App\Actions\Resume;

use App\Actions\Education\StoreEducationAction;
use App\Actions\Experience\StoreExperienceAction;
use App\Actions\PersonalDetail\StorePersonalDetailAction;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreResumeAction
{
    public function __invoke(Request $request): void
    {
        DB::transaction(function() use($request) {
            $user = Auth::user();
            $resume = $user->resumes()->create([
                'name' => $request->input('name') ?? $this->generateUntitledName(),
                'code' => $this->generateCode()
            ]);
    
            (new StorePersonalDetailAction)($request, $resume);

            foreach($request->input('experiences') as $experience) {
                (new StoreExperienceAction)(new Request($experience), $resume);
            }

            foreach($request->input('educations') as $education) {
                (new StoreEducationAction)(new Request($education), $resume);
            }
        });
    }

    private function generateCode(): string
    {
        $unique = false;
        
        do {
            $code = Str::random(12);

            $resumeCount = Resume::where('code', $code)->count('id');
            if($resumeCount == 0) {
                $unique = true;
            }
        } 
        while(!$unique);

        return $code;
    }

    private function generateUntitledName(): string
    {
        $untitledName = 'Untitled';
        $count = 1;

        $resume = Auth::user()->resumes()->where('name', $untitledName)->orWhereRaw("name REGEXP '^$untitledName-[0-9]*$'")->latest()->first();
        if($resume) {
            $nameArray = explode('-', $resume->name);
            if(isset($nameArray[1])) {
                $count = $nameArray[1];
            }
            $count++;
        }

        return $untitledName . ($count == 1 ? '' : '-'.$count);
    }
}