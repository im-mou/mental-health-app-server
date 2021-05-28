<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Journal;
use App\Models\Chat;
use App\Models\Question;
use Validator;

use App\Resources\Journal as JournalResource;
use App\Resources\Chat as ChatResource;

class JournalService {

    public function getJournalFromDate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token'   => 'required',
            'date'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();

            $token = $data['token'];
            $date = $data['date'];


            $user = User::where('password', '=', $token)->firstOrFail();


            $journal = Journal::where([['user_id', '=', $user->id], ['date', '=', $date ]])->firstOrFail();

            return new JournalResource($journal);
        }

    }

    public function getJournalFromMonth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token'   => 'required',
            'month'   => 'required',
            'year'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {

            $data = $request->all();
            $token = $data['token'];
            $month = $data['month'];
            $year = $data['year'];
            $user = User::where('password', '=', $token)->firstOrFail();

            $journal = Journal::where([['user_id', '=', $user->id], ['date', 'like', '%-'.$month.'-'.$year]])->get();

            return JournalResource::collection($journal);

        }


    }

    public function getTodayJournal(Request $request)
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

            $journal = Journal::where(['user_id' => $user->id, 'date' => date('d-m-Y')])->get();

            if($journal->chats()->count() == 0) {

                // primera entrada al journal
                $chat = new Chat();

                $chat->journal_id = $journal->id;
                $chat->type = 'question';
                $chat->body = Question::inRandomOrder()->first()->body;

                $chat->save();

            }

            return new JournalResource($journal);

        }


    }

    public function addJournalEntry(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token'         => 'required',
            'journal_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {


            $data = $request->all();
            $token = $data['token'];
            $journal_id = $data['journal_id'];
            $user = User::where('password', '=', $token)->firstOrFail();


            $journal = Journal::where('id', $journal_id)->where('user_id', $user->id)->firstorfail();



            if($journal->remaining_questions > 0) {

                $journal->remaining_questions = $journal->remaining_questions - 1;
                $journal->save();

                $data = $request->all();
                $text = $data['text'];

                // primera entrada al journal
                $answer = new Chat();
                $answer->journal_id = $journal->id;
                $answer->type = 'answer';
                $answer->body = $text;
                $answer->save();


                if($journal->remaining_questions == 0) {

                    $next_question = new Chat();
                    $next_question->journal_id = $journal->id;
                    $next_question->type = 'question';
                    $next_question->body = 'Todo Hecho!';

                    $next_question->save();

                } else {

                    $next_question = new Chat();
                    $next_question->journal_id = $journal->id;
                    $next_question->type = 'question';
                    $next_question->body = Question::inRandomOrder()->first()->body;
                    $next_question->save();

                }

                return ChatResource::collection(collect([$answer, $next_question]));

            }

            return [];
        }

    }


    public function updateCurrentSentiment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token'             => 'required',
            'sentiment_index'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Los campos no eran validos',
            ], 422);
        } else {


            $data = $request->all();
            $token = $data['token'];
            $sentiment_index = $data['sentiment_index'];

            $user = User::where('password', '=', $token)->firstOrFail();

            $journal = Journal::firstOrCreate(['user_id' => $user->id, 'date' => date('d-m-Y')]);

            $journal->sentiment_index = $sentiment_index;
            $journal->save();

            return new JournalResource($journal);

        }

    }


    public function generateJournalForCurrentMonth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token'             => 'required',
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

            $journal = Journal::where([['user_id', '=', $user->id], ['date', 'like', '%-'.date('m').'-'.date('Y')]])->get();

            if($journal->count() == 0) {

                $data = [];
                $header = ['user_id','date'];

                for ($i=0; $i < date('t'); $i++) {
                    $row = [$user->id, sprintf("%02d",($i+1)).'-'.date('m').'-'.date('Y')];
                    $data[] = array_combine($header, $row);
                }

                Journal::insert($data);
            }

        }

    }

}
