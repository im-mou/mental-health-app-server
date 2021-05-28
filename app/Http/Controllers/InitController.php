<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

use App\Services\InitService;

class InitController extends Controller
{
    private $initService;

    function __construct(){

        $this->initService = new InitService();
    }

    public function index()
    {
        $this->initService->populateQuestions();
        $this->initService->populateInterests();
        $this->initService->populateRecomendations();

        return json_encode(['response' => 'done']);
    }

}
