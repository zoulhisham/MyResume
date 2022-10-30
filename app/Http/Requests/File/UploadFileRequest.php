<?php

namespace App\Http\Requests\File;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'id' => 'nullable|exists:resumes',
           'file' => 'required|image|mimes:jpeg,jpg,png|max:20'
        ];
    }
}
