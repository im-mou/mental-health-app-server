<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

use App\Services\InterestService;

class InterestController extends Controller
{
    private $interestService;

    function __construct(){

        $this->interestService = new InterestService();
    }

    public function getInterests(Request $request)
    {
        return json_encode($this->interestService->getInterests($request));
    }

    public function updateInterests(Request $request)
    {
        return json_encode($this->interestService->updateInterests($request));
    }
}
