<?php

namespace App\Http\Controllers;

use App\Actions\File\UploadFileAction;
use App\Http\Requests\File\UploadFileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request, UploadFileAction $uploadFileAction)
    {
        $path = $uploadFileAction($request);

        return response()->json([
            'image' => $path,
            'image_url' => Storage::url($path)
        ]);
    }
}
