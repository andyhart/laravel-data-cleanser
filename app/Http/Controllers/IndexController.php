<?php

namespace App\Http\Controllers;

use App\DataCleanser\DataCleanser;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function showReport()
    {
        $data = file_get_contents(app_path('data.json'));
        $cleanser = new DataCleanser(json_decode($data));
        $report = $cleanser->analyse();

        return view('report')->with(compact('report'));
    }
}
