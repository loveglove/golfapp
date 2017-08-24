<?php

namespace App\Http\Controllers;
use Session;
use App\Team;
use App\Tournament;
use App\Matchup;
use App\Score;
use App\Hole;
use Request;
use Auth;
use DB;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TeamRepository;

class AdminController extends Controller
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
    public function getAdminView()
    {
        if(Auth::user()->getId() == 1)
        {
            return view('admin', [
                'tournaments' => Tournament::all(),
                'openteams' => $this->team->getTeamListOpen(),
                'teams' => $this->team->getTeamListAll(),
                'allteams' => $this->team->getAllTeams(),
                'matchups' => $this->team->getMatchups(),
                'active_tour' => Session::get('tournament')
            ]);
        } else {
            return view('welcome');
        }
    }

    /*
     * Activate the tour
     *
     */
    public function activateTour(Request $request)
    {

        DB::table('tournament')->update(['active' => 0]);

        $id = Request::input('tour_id');
        DB::table('tournament')->where('id','=',$id)->update(['active' => 1]);

        $newtour = Tournament::where('active','=', 1)->first();
        Session::set('tournament', $newtour);
        // dd($newtour);
        return $this->getAdminView();

    }


    /*
     * Create matchup
     *
     */
    public function createMatchup(Request $request)
    {
        $id_team1 = Request::input('team1');
        $id_team2 = Request::input('team2');

        $newteam = new Matchup;
        $newteam->id_tour = Session::get('tournament')->id;
        $newteam->id_team1 = $id_team1;
        $newteam->id_team2 = $id_team2;
        $team1 = Team::where('id', '=', $id_team1)->first();
        $team2 = Team::where('id', '=', $id_team2)->first();
        $newteam->name1 = $team1->name;
        $newteam->name2 = $team2->name;
        $newteam->active = 1;
        $newteam->save();

        return $this->getAdminView();
    }

    /*
     * Delete matchup
     *
     */
    public function deleteMatchup(Request $request)
    {
        $id = Request::input('matchup');
        Matchup::where('id','=', $id)->delete();
        return $this->getAdminView();
    }


    /*
     * Delete team
     *
     */
    public function deleteTeam(Request $request)
    {
        $id = Request::input('team');
        Team::where('id','=', $id)->delete();
        return $this->getAdminView();
    }

    /*
     * Eject mate
     *
     */
    public function ejectMate(Request $request)
    {
        $id = Request::input('mate');
        DB::table('teams')->where('id_user2','=',$id)->update(['id_user2' => NULL]);
        return $this->getAdminView();
    }

    /*
     * Update Score
     *
     */
    public function updateScore(Request $request)
    {
        $tour_id = Session::get('tournament')->id;
        $course_id = Session::get('tournament')->id_course;
        $team_id = Request::input('team');
        $hole = Request::input('hole');
        $value = Request::input('value');

        $score = Score::where('id_team', $team_id)->where('hole', $hole)->first();

        if(!empty($score))
        {
            Score::where('id_team', $team_id)->where('hole', $hole)->update(['score' => $value]);
        }
        else
        {
            $holeFetch = Hole::where('id_course', $course_id)->where('hole',$hole )->first();
            $score = new Score;
            $score->id_tour = $tour_id;
            $score->id_team = $team_id;
            $score->hole = $hole;
            $score->par = $holeFetch->par;
            $score->score = $value;
            $score->save();

        }
        
        return $this->getAdminView();
    }

    /*
     * Clear Score
     *
     */
    public function clearScore(Request $request)
    {
        $id = Request::input('team');
        DB::table('scores')->where('id_team','=',$id)->delete();
        return $this->getAdminView();
    }

}