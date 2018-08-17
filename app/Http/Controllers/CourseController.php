<?php

namespace App\Http\Controllers;

use Session;
use App\Course;
use App\Team;
use App\Score;
use App\Notification;
use App\Tournament;
use App\Award;

use Request;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\TeamRepository;


class CourseController extends Controller
{

    protected $course;
     
    protected $team;

    /*
     * Create a new controller instance.
     *
     * @param  CourseRepository  $course
     * @return void
     */
    public function __construct(CourseRepository $course, TeamRepository $team)
    {
        $this->middleware('auth');
        $this->course = $course;
        $this->team = $team;
        $this->tournament = Tournament::where('active', 1)->first();
    }


    /**
     * Display a list of all of the course's holes.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getHoles(Request $request)
    {

    /*  return a view (aka blade page) with an array. 
        The 2 array items are populated with data from local 
        instance of team and local instance of course 
        (and there respectively called functions)         */

        $myTeam = $this->team->getTeam();

        $course = $this->course->getCourse();

        foreach($course as $hole){

        	$best = Score::where('id_tour', $this->tournament->id)->where('hole', $hole->hole)->min('score');
        	$hole['best'] = $best;

        }

        // dd($course);

        if($myTeam){
            return view('scorecard', [
                'course' => $course,
                'team' => $myTeam,
                'completed' => $this->team->getCompleted($myTeam->id), 
                'users' => $this->team->getUsers(),
                'score' => $this->team->getScore(),
            ]);
        }else{
            return view('home', [
                'teams' => $this->team->getTeamListOpen()
            ]);
        }
        
    }


    /**
     * Insert score per hole
     *
     * @param  Request  $request
     */
    public function insertScore(Request $request)
    {
        $myTeam = $this->team->getTeam();

        if(Request::ajax()) {
            $data = Request::all();
            $score = new Score;
            $score->id_team = $myTeam->id;
            $score->id_tour = $this->tournament->id;
            $score->hole = $data['hole'];
            $score->par = $data['par'];
            $score->score = $data['score'];
            $score->save();
            return $data;
        }
        return 0;
    }

    public function insertNotification(Request $request)
    {
        if(Request::ajax())
        {
            $data = Request::all();
            $note = new Notification;
            $note->team_id = $data['team_id'];
            $note->tournament_id = $this->tournament->id;
            $note->text = $data['text'];
            $note->save();
            return $data;
        }
        return 0;
    }


    public function insertAward(Request $request, $type)
    {
    	$tournament = Tournament::where('active', 1)->first();
    	
    	Award::create([
    		"id_tour" => $tournament->id,
    		"id_course" => $tournament->id_course,
    		"id_team" => Request::input('id'),
    		"type" => $type,
    		"hole" => Request::input('hole'),
    		"name" => Request::input('name')
    	]);

    	return 1;

    }


    /**
     * Get Team score totaled
     *
     * @param  Request  $request
     */
    public function getScore(Request $request)
    {
        if(Request::ajax()) {
            return $this->team->getScore();
        }
        return 999;
    }


}
