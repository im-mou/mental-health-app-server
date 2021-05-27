<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Interest;
use App\Models\UserInterest;
use Validator;
use Hash;

use App\Resources\Interest as InterestResource;
use App\Resources\User as UserResource;

class UserService {

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'interest' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();
            $name = $data['name'];
            $interests = explode("|", $data['interest']);

            $user = new User();
            $user->name = $name;
            $user->password = Hash::make(date('d-m-Y H:s:i').''.$name);
            $user->email = $name.date('d-m-Y-H-s-i').'@mental-health-app.com';
            $user->save();

            for ($i=0; $i < count($interests); $i++) {
                $interest = Interest::where('id', '=', $interests[$i])->first();
                $user_interest = new UserInterest();

                $user_interest->user_id = $user->id;
                $user_interest->interest_id = $interest->id;

                $user_interest->save();

            }

            return ['token' => $user->password];


        }
    }

    public function getUserInfoFromToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();
            $token = $data['token'];

            $user = User::where('password', '=', $token)->firstOrFail();

            return ['user' => new UserResource($user), 'interests' => InterestResource::collection($user->interests)];

        }
    }

    public function toggleNotifications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();
            $token = $data['token'];

            $user = User::where('password', '=', $token)->firstOrFail();
            $user->notifications = !$user->notifications;
            $user->save();

            return ['notifications' => $user->notifications];

        }
    }

    public function updateUserData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'   => 'required',
            'name'   => 'required',
            'sleep_time'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();
            $token = $data['token'];
            $name = $data['name'];
            $sleep_time = $data['sleep_time'];

            $user = User::where('password', '=', $token)->firstOrFail();
            $user->name = $name;
            $user->sleep_time = $sleep_time;
            $user->save();

            return ['user' => new UserResource($user), 'interests' => InterestResource::collection($user->interests)];

        }
    }

}
