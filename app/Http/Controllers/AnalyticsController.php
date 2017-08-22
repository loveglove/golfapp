<?php

namespace App\Http\Controllers;

use Session;
use App\Course;
use App\Team;
use App\Score;
use Request;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\StandingsRepository;
use App\Repositories\TeamRepository;

class AnalyticsController extends Controller
{

    // protected $courseRepo;
    // protected $teamRepo;

    public function __construct(StandingsRepository $standingsRepo, TeamRepository $teamRepo)
    {
        $this->middleware('auth');
        $this->tournament = Session::get('tournament');
        $this->standingsRepo = $standingsRepo;
        $this->teamRepo = $teamRepo;
    }


    public function show()
    {
        $team_id = $this->teamRepo->getTeam()->id;
        $myscores = $this->teamRepo->getCompletedValues($team_id);
        $averages = $this->standingsRepo->getHoleAverage($this->tournament->id, count($myscores));
        $avgscore = $this->teamRepo->getTourAverage();

        return view('analytics', [
            'statistics' => $this->teamRepo->getStatistics(),
            'myscores' => $myscores,
            'averages' => $averages,
            'avgscore' => $avgscore,
        ]);
    }




}


