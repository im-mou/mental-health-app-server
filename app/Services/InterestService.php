<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Interest;
use App\Models\UserInterest;
use Validator;

use App\Resources\Interest as InterestResource;
use App\Resources\User as UserResource;
use Illuminate\Support\Facades\Storage;

class InterestService {

    public function populateInterests()
    {

        $rows = array_map(function ($v) {
            return str_getcsv($v, ";");
        }, file(storage_path('app/Recomendaciones.csv')));

        $header = array_shift($rows);
        $csv    = [];

        foreach ($rows as $row) {
            $row[1] = (int) $row[1];
            $row[2] = floatval(str_replace(',', '.', $row[2]));
            $csv[] = array_combine($header, $row);
        }

        Interest::insert($csv);

    }

    public function getAllInterests()
    {
        return InterestResource::collection(Interest::all());
    }

    public function getInterests(Request $request)
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
            $user = User::where('password', '=', $data['token'])->firstOrFail();

            return InterestResource::collection($user->interests);

        }
    }

    public function updateInterests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'   => 'required',
            'interest' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();
            $user = User::where('password', '=', $data['token'])->firstOrFail();
            $interests = explode("|", $data['interest']);

            UserInterest::where('user_id', $user->id)->delete();

            for ($i=0; $i < count($interests); $i++) {
                $interest = Interest::where('id', '=', $interests[$i])->first();
                $user_interest = new UserInterest();

                $user_interest->user_id = $user->id;
                $user_interest->interest_id = $interest->id;

                $user_interest->save();

            }

            return InterestResource::collection($user->interests);

        }
    }

}
