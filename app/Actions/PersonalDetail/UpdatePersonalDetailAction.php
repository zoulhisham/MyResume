<?php

namespace App\Actions\PersonalDetail;

use App\Models\PersonalDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdatePersonalDetailAction
{
    public function __invoke(Request $request, PersonalDetail $personalDetail)
    {
        $profileImage = $personalDetail->profile_image;
        if($request->hasFile('profile_image')) {
            Storage::delete($personalDetail->profile_image);
            $profileImage = $request->file('profile_image')->store("public/images/resumes/{$personalDetail->resume_id}");
        }

        $personalDetail->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'birth_date' => (new Carbon($request->input('birth_date')))->format('Y-m-d'),
            'gender' => $request->input('gender'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'state_id' => $request->input('state_id'),
            'country_id' => $request->input('country_id'),
            'profile_image' => $profileImage
        ]);
    }
}