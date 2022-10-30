<?php

namespace App\Http\Requests\PersonalDetail;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StorePersonalDetailRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'phone_no' => 'required|max:20',
            'birth_date' => 'required|before:tomorrow',
            'gender' => 'required|in:'.implode(',', array_map(fn(Gender $status) => $status->value, Gender::cases())),
            'address1' => 'required',
            'address2' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'birth_date' => (new Carbon($this->input('birth_date')))->format('Y-m-d'),
        ]);
    }
}
