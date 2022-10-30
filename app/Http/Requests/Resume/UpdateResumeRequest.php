<?php

namespace App\Http\Requests\Resume;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeRequest extends FormRequest
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
            // resume
            'name' => 'max:255',

            // personal detail
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
            'profile_image' => 'nullable|image|max:20|mimes:jpeg,jpg,png',

            // experience
            'experiences.*.position' => 'required|max:255',
            'experiences.*.company_name' => 'required|max:255',
            'experiences.*.start_date' => 'required',
            'experiences.*.end_date' => 'required_if:experiences.*.is_present,false',
            'experiences.*.city' => 'required|max:255',
            'experiences.*.description' => 'required',

            // education
            'educations.*.school' => 'required|max:255',
            'educations.*.qualification' => 'required|max:255',
            'educations.*.start_date' => 'required',
            'educations.*.end_date' => 'required_if:educations.*.is_present,false',
            'educations.*.city' => 'required|max:255',
            'educations.*.description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'experiences.*.position.required' => 'The position is required',
            'experiences.*.company_name.required' => 'The company name is required',
            'experiences.*.start_date.required' => 'The start date is required',
            'experiences.*.end_date.required_if' => 'The end date is required',
            'experiences.*.city.required' => 'The city is required',
            'experiences.*.description.required' => 'The description is required',

            'educations.*.school.required' => 'The school is required',
            'educations.*.qualification.required' => 'The qualification is required',
            'educations.*.start_date.required' => 'The start date is required',
            'educations.*.end_date.required_if' => 'The end date is required',
            'educations.*.city.required' => 'The city is required',
            'educations.*.description.required' => 'The description is required',
        ];
    }
}
