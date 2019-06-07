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
        if(Auth::user()->isAdmin())
        {
            return view('admin', [
                'tournaments' => Tournament::all(),
                'tourList' => Tournament::lists('name', 'id'),
                'openteams' => $this->team->getTeamListOpen(),
                'teams' => $this->team->getTeamListAll(),
                'allteams' => $this->team->getAllTeams(),
                'matchups' => $this->team->getMatchups(),
                'active_tour' => Tournament::where('active','=', 1)->first()
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
        Team::find($id)->delete();
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
        $tournament = Tournament::where('active', 1)->first();
        $team_id = Request::input('team');
        $hole = Request::input('hole');
        $value = Request::input('value');
        $strokes = null;

        $holeFetch = Hole::where('id_course', $tournament->id_course)->where('hole', $hole)->first();

        if(Request::has('value_text')){
            
            switch(Request::input('value_text'))
            {
                case "-2":
                    $strokes = $holeFetch->par - 2;
                break;
                case "-1":
                    $strokes = $holeFetch->par - 1;
                break;
                case "0":
                    $strokes = $holeFetch->par;
                break;
                case "+1":
                    $strokes = $holeFetch->par + 1;
                break;
                case "+2":
                    $strokes = $holeFetch->par + 2;
                break;
                default:
                    $strokes = $value;
                break;
            }
        }else{
            $strokes = $value;
        }

        $score = Score::where('id_team', $team_id)
                        ->where('id_tour', $tournament->id)
                        ->where('hole', $hole)
                        ->first();

        // if score already exists update it. If not create a new record
        if(!empty($score))
        {
            $score->update(['score' => $strokes]);
        }
        else
        {

            $score = new Score;
            $score->id_tour = $tournament->id;
            $score->id_team = $team_id;
            $score->hole = $hole;
            $score->par = $holeFetch->par;
            $score->score = $strokes;
            $score->save();

        }
        return
         $this->getAdminView();
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


    /*
     * Clear Tour
     *
     */
    public function clearTour(Request $request)
    {
        $tour = Tournament::where('active', 1)->first();

        DB::table('scores')->where('id_tour', $tour->id)->delete();
        DB::table('notifications')->where('tournament_id', $tour->id)->delete();
        DB::table('awards')->where('id_tour', $tour->id)->delete();

        return $this->getAdminView();
    }


    /*
     * Edit A Team
     *
     */
    public function teamEdit(Request $request, $teamid)
    {

        return view('editteam',[
            "team" => Team::find($teamid),
            "members" => array_filter($this->team->getTeamUsers($teamid))
        ]);

    }


    /*
     * Edit A Team
     *
     */
    public function updateName(Request $request)
    {
        $data = Request::all();
        $team = Team::find($data["id"]);
        $team->name = $data["name"];
        $team->save();
        return redirect('/team/edit/'.$data["id"])->withErrors(['name' => 'Team name updated.']);

    }

    /*
     * Update member names
     *
     */
    public function updateMemberNames(Request $request)
    {
        $data = Request::all();
        $team = Team::find($data["id"]);
        $team->members = $data["membername"];
        $team->save();
        return redirect('/team/edit/'.$data["id"])->withErrors(['membername' => 'Member names updated.']);

    }


    /*
     * Set Team Members
     *
     */
    public function setMembers(Request $request)
    {
        $data = Request::all();
        $team = Team::find($data["id"]);
        $team->members = $data["name"];
        $team->save();
        return 1;
    }

    /*
     * Clear Team Score
     *
     */
    public function clearTeamScore(Request $request)
    {
        $tournament = Tournament::where('active', 1)->first();
        $data = Request::all();     
        DB::table('scores')->where('id_tour', $tournament->id)->where("id_team", $data["id"])->delete();
        DB::table('notifications')->where('tournament_id', $tournament->id)->where('team_id', $data["id"])->delete();
        DB::table('awards')->where('id_tour', $tournament->id)->where('id_team', $data["id"])->delete();

        return redirect('/team/edit/'.$data["id"])->withErrors(['clear' => 'Team scores cleared.']);

    }



    /*
     * Eject Team Memver
     *
     */
    public function ejectMember(Request $request)
    {

        $data = Request::all();   

        $team = Team::find($data["team_id"]);

        if($team->id_user1 == $data["user_id"]){
            $team->id_user1 = NULL;
        }else if($team->id_user2 == $data["user_id"]){
            $team->id_user2 = NULL;
        }else if($team->id_user3 == $data["user_id"]){
            $team->id_user3 = NULL;
        }else if($team->id_user4 == $data["user_id"]){
            $team->id_user4 = NULL;
        }

        $team->save();

        return redirect('/team/edit/'.$data["team_id"]);

    }


    /*
     * Set holes for longest drive and closest to the pin
     *
     */
    public function setAwardHoles(Request $request)
    {
        // remove previous settings

        $tournament = Tournament::where('active', 1)->first();

        Hole::where('id_course', $tournament->id_course)
            ->update(['cpm' => 0, 'cpw' => 0, 'ldm' => 0, 'ldw' => 0]);

        // set mens awards to holes
        Hole::where('id_course', $tournament->id_course)
            ->where('hole', Request::input('cpm'))
            ->update(['cpm' => 1]);

        Hole::where('id_course', $tournament->id_course)
            ->where('hole', Request::input('ldm'))
            ->update(['ldm' => 1]);

        // set womens awards to holes
        Hole::where('id_course', $tournament->id_course)
            ->where('hole', Request::input('cpw'))
            ->update(['cpw' => 1]);

        Hole::where('id_course', $tournament->id_course)
            ->where('hole', Request::input('ldw'))
            ->update(['ldw' => 1]);


        return back()->withErrors(['awards' => 'Holes '.Request::input('cpm'). ' and '.Request::input('ldm'). ' set for closest and longest for men. Holes '.Request::input('cpw'). ' and '.Request::input('ldw').' set for closest and longest for women']);
    }  



    /*
     * Set starting hole for a team
     *
     */
    public function setStartHole(Request $request)
    {

        $data = Request::all();   
        $team = Team::find($data["id"]);
        $team->start = $data["start"];
        $team->save();
        return redirect('/team/edit/'.$data["id"])->withErrors(['starthole' => 'Starting hole set to '.$data["start"]]);

    }

}