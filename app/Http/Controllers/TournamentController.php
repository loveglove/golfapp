<?php

namespace App\Http\Controllers;
use Session;
use App\Team;
use App\Tournament;
use Request;
use Auth;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TeamRepository;

class TournamentController extends Controller
{
    /*
     * Repository instance.
     */
    protected $team;


    public function __construct(TeamRepository $team)
    {
        $this->middleware('auth');
        $this->team = $team;
    }


    /*
     * Get the acive tournament
     *
     */
    public function getActiveTour(Request $request)
    {
        $tournament = Tournament::where('active', '=', 1)->first();
        Session::set('tournament', $tournament);
        if(!$tournament){
            return view('error');
        }

        $hasTeam = $this->team->getTeam();
        if($hasTeam){
            return redirect()->action('CourseController@getHoles');
        } else {
            return $this->getExistingTeams();
        }
    }


    /*
     * Get the existing teams
     *
     */
    public function getExistingTeams()
    {
        return view('home', [
            'teams' => $this->team->getTeamListOpen()
        ]);
    }


    /*
     * Create a tournament
     *
     */
    public function createTour(Request $request)
    {

        $tournament = new Tournament;
        $tournament->id_course = Request::input('course');
        $tournament->name = Request::input('tournament');
        $tournament->type = Request::input('type');
        $active =  Request::input('active');
        if($active){
            DB::table('tournament')->update(['active' => 0]);
            $tournament->active = 1;
        } else{
             $tournament->active = 0;
        }
        $tournament->save();
        return redirect()->action('AdminController@getAdminView');
    }

    /*
     * Create a team sadasd sasdasd
     *
     */

    public function createTeam(Request $request)
    {

        $newteam = new Team;
        $newteam->id_tour = Session::get('tournament')->id;
        $newteam->id_user1 = Auth::user()->getId();
        $newteam->name = Request::input('teamname');
        $newteam->save();
        return redirect()->action('CourseController@getHoles');
    }

    /*
     * Join a team
     *
     */
    public function joinTeam(Request $request)
    {
        $team = Request::input('team');
        Team::where('id', $team)->update(['id_user2' => Auth::user()->getId()]);

        return redirect()->action('CourseController@getHoles');
    }

}