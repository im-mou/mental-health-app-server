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
        $data = $request->all();

        $date = $data['date'];
        $user_id = $data['user_id'];

        $journal = Journal::where([['user_id', '=', $user_id], ['date', '=', $date ]])->firstOrFail();

        return new JournalResource($journal);
    }

    public function getJournalFromMonth(Request $request, $user_id, $month, $year)
    {

        $journal = Journal::where([['user_id', '=', ],['date', 'like', '%/'.$month.'/'.$year]])->get();

        return $journal;
    }

    public function getTodayJournal(Request $request, $user_id)
    {

        $journal = Journal::firstOrCreate(['user_id' => $user_id, 'date' => date('d/m/Y')]);

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

    public function addJournalEntry(Request $request, $journal_id, $user_id)
    {

        $journal = Journal::where('id', $journal_id)->where('user_id', $user_id)->firstorfail();


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
