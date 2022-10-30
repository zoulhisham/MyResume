<?php

namespace App\Http\Controllers;

use App\Actions\Resume\CreateResumeAction;
use App\Http\Requests\PersonalDetail\StorePersonalDetailRequest;
use Illuminate\Http\Request;

class PersonalDetailController extends Controller
{
    public function __construct(
        private CreateResumeAction $createResumeAction
    )
    {

    }

    public function store(StorePersonalDetailRequest $request)
    {
        $this->createResumeAction($request);
    }
}
