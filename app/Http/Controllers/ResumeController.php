<?php

namespace App\Http\Controllers;

use App\Actions\Resume\GetResumeListAction;
use App\Actions\Resume\StoreResumeAction;
use App\Actions\Resume\UpdateResumeAction;
use App\Enums\Gender;
use App\Http\Requests\Resume\StoreResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Http\Resources\ResumeResource;
use App\Models\Country;
use App\Models\Resume;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ResumeController extends Controller
{
    public function index(GetResumeListAction $getResumeListAction)
    {
        $resumes = $getResumeListAction();

        return Inertia::render('Resume/Index', [
            'resumes' => ResumeResource::collection($resumes)
        ]);
    }

    public function create()
    {
        return Inertia::render('Resume/Form', [
            'genderList' => array_map(
                fn(Gender $status) => [
                    'id' => $status->value,
                    'name' => $status->name
                ], 
                Gender::cases()
            ),
            'countries' => Country::get(['id', 'name']),
            'title' => 'Create',
            'action' => 'create'
        ]);
    }

    public function store(StoreResumeRequest $request, StoreResumeAction $storeResumeAction)
    {
        $storeResumeAction($request);
        return redirect()->route('resumes.index')->with('success', 'Resume successfully created');
    }

    public function edit(Request $request, Resume $resume)
    {
        $resume->load('personalDetail', 'experiences', 'educations');
        return Inertia::render('Resume/Form', [
            'genderList' => array_map(
                fn(Gender $status) => [
                    'id' => $status->value,
                    'name' => $status->name
                ], 
                Gender::cases()
            ),
            'countries' => Country::get(['id', 'name']),
            'states' => State::where('country_id', $resume->personalDetail->country_id)->get(),
            'title' => 'Edit',
            'resume' => new ResumeResource($resume),
            'action' => 'edit',
        ]);
    }

    public function update(UpdateResumeRequest $request, UpdateResumeAction $updateResumeAction, $id)
    {
        $resume = Resume::find($id);

        abort_if(
            !$resume,
            Response::HTTP_NOT_FOUND
        );

        $updateResumeAction($request, $resume);
        return redirect()->route('resumes.index')->with('success', 'Resume successfully updated');
    }

    public function display(Request $request, $code)
    {
        $resume = Resume::where('code', $code)->first();
        
        abort_if(
            !$resume,
            Response::HTTP_NOT_FOUND,
        );

        $resume->load('personalDetail', 'experiences', 'educations');

        $resume->append('latestJob');

        return Inertia::render('Resume/View', [
            'resume' => new ResumeResource($resume)
        ]);
    }
}
