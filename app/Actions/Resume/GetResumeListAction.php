<?php

namespace App\Actions\Resume;

use App\Models\Resume;

class GetResumeListAction
{
    public function __invoke()
    {
        $resumes = Resume::query()
            ->paginate();

        return $resumes;
    }
}