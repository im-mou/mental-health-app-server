<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Journal;
use App\Models\Recomendations;
use App\Models\Interest;
use App\Models\UserInterest;
use Validator;
use Hash;
use Carbon\Carbon;

use App\Resources\Recomendation as RecomendationResource;

class RecomendationService {

    public function getReomendations(Request $request)
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

            $yesterday = Carbon::yesterday()->format('d-m-Y');

            $data = $request->all();
            $token = $data['token'];
            $user = User::where('password', '=', $token)->firstOrFail();

            $journal = Journal::where(['user_id' => $user->id, 'date' => $yesterday])->first();

            if($journal == null){
                $recs = Recomendations::inRandomOrder()->limit(2)->get();
            } else {
                $recs = Recomendations::where('sentiment_index', 'like', round($user->sentiment_index, 1))->limit(2)->get();
            }

            return RecomendationResource::collection($recs);
        }
    }

}
