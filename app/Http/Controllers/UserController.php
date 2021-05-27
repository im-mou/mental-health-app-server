<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


use App\Services\UserService;

class UserController extends Controller
{

    private $userService;

    function __construct(){

        $this->userService = new UserService();
    }

    public function index(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        return json_encode($this->userService->registerUser($request));
    }

    public function getUser(Request $request)
    {
        return json_encode($this->userService->getUserInfoFromToken($request));
    }

    public function toggleNotifications(Request $request)
    {
        return json_encode($this->userService->toggleNotifications($request));
    }

    public function updateUserData(Request $request)
    {
        return json_encode($this->userService->updateUserData($request));
    }

}
