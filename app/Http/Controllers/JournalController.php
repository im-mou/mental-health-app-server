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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return json_encode($this->journalService->getJournalFromDate($request));
    }

    public function getMonthJournal(Request $request, $user_id, $month, $year)
    {
        return json_encode($this->journalService->getJournalFromMonth($request, $user_id, $month, $year));
    }

    public function getTodayJournal(Request $request, $user_id)
    {
        return json_encode($this->journalService->getTodayJournal($request, $user_id));
    }

    public function addJournalEntry(Request $request, $journal_id, $user_id)
    {
        return json_encode($this->journalService->addJournalEntry($request, $journal_id, $user_id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
