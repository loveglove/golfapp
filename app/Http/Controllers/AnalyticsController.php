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
use App\Repositories\CourseRepository;
use App\Repositories\TeamRepository;

class AnalyticsController extends Controller
{

    // protected $courseRepo;
    // protected $teamRepo;

    public function __construct(CourseRepository $courseRepo, TeamRepository $teamRepo)
    {
        $this->middleware('auth');
        $this->tournament = Session::get('tournament');
        $this->courseRepo = $courseRepo;
        $this->teamRepo = $teamRepo;
    }


    public function show()
    {
        return view('analytics', [
            'course' => $this->courseRepo->getCourse(),
            'statistics' => $this->teamRepo->getStatistics(),
        ]);
    }




}


