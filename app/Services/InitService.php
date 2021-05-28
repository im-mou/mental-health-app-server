<?php

namespace App\Services;

use Illuminate\Http\Request;


use App\Models\Interest;
use App\Models\Question;
use App\Models\Recomendations;

class InitService {

    public function populateRecomendations()
    {

        $rows = array_map(function ($v) {
            return str_getcsv($v, ";");
        }, file(public_path('Recomendaciones.csv')));

        $header = array_shift($rows);
        $csv    = [];

        foreach ($rows as $row) {
            $row[1] = (int) $row[1];
            $csv[] = array_combine($header, $row);
        }

        Recomendations::insert($csv);

    }

    public function populateQuestions()
    {

        $rows = array_map(function ($v) {
            return str_getcsv($v, ";");
        }, file(public_path('Questions.csv')));

        $header = array_shift($rows);
        $csv    = [];

        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        Question::insert($csv);

    }

    public function populateInterests()
    {

        $rows = array_map(function ($v) {
            return str_getcsv($v, ";");
        }, file(public_path('Interests.csv')));

        $header = array_shift($rows);
        $csv    = [];

        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        Interest::insert($csv);

    }

}
