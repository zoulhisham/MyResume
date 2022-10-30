<?php

namespace App\Actions\File;

use Illuminate\Http\Request;

class UploadFileAction
{
    public function __invoke(Request $request)
    {
        if($request->has('id')) {
            $path = $request->file('file')->store("public/images/resumes/{$request->input('id')}");
        } else {
            $path = $request->file('file')->store("public/images/temp");
        }

        return $path;
    }
}