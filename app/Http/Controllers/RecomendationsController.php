<?php

namespace App\Http\Controllers;

use App\Models\Recomendations;
use Illuminate\Http\Request;

use App\Services\RecomendationService;

class RecomendationsController extends Controller
{
    private $recomendationService;

    function __construct(){

        $this->recomendationService = new RecomendationService();
    }

    public function index(Request $request)
    {
        return json_encode($this->recomendationService->getReomendations($request));
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
     * @param  \App\Models\Recomendations  $recomendations
     * @return \Illuminate\Http\Response
     */
    public function show(Recomendations $recomendations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recomendations  $recomendations
     * @return \Illuminate\Http\Response
     */
    public function edit(Recomendations $recomendations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recomendations  $recomendations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recomendations $recomendations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recomendations  $recomendations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recomendations $recomendations)
    {
        //
    }
}
