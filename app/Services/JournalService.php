<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Journal;
use App\Models\Chat;

use App\Resources\Journal as JournalResource;

class JournalService {

    public function getJournal(Request $request)
    {
        $data = $request->all();

        $date = $data['date'];

        $journal = Journal::where('date', $date)->get();

        return new JournalResource($journal);
    }

}
