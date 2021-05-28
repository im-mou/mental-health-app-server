<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;


use App\Services\JournalService;

class JournalController extends Controller
{

    private $journalService;

    function __construct(){

        $this->journalService = new JournalService();
    }

    public function index(Request $request)
    {
        return json_encode($this->journalService->getJournalFromDate($request));
    }

    public function getMonthJournal(Request $request)
    {
        return json_encode($this->journalService->getJournalFromMonth($request));
    }

    public function getTodayJournal(Request $request)
    {
        return json_encode($this->journalService->getTodayJournal($request));
    }

    public function addJournalEntry(Request $request)
    {
        return json_encode($this->journalService->addJournalEntry($request));
    }

    public function updateCurrentSentiment(Request $request)
    {
        return json_encode($this->journalService->updateCurrentSentiment($request));
    }

    public function generateJournalForCurrentMonth(Request $request)
    {
        return json_encode($this->journalService->generateJournalForCurrentMonth($request));
    }

}
