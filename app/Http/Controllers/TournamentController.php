<?php

namespace App\Http\Controllers;
use Session;
use App\Team;
use App\Tournament;
use App\Notification;
use Request;
use Redirect;
use Auth;
use Input;
use Validator;
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
        $validator = Validator::make(Request::all(), [
            'teamname' => 'required|max:24',
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }


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


        if(empty(Request::input('team'))){
            return Redirect::back()->withErrors(['join' => 'You must select a team']);
        }

        $team = Team::find(Request::input('team'));

        if(empty($team->id_user4)){
            if(empty($team->id_user3)){
                if(empty($team->id_user2)){
                    if(empty($team->id_user1)){
                        $team->id_user1 = Auth::user()->id;
                    }else{
                        $team->id_user2 = Auth::user()->id;
                    }
                }else{
                    $team->id_user3 = Auth::user()->id;
                }
            }else{
                $team->id_user4 = Auth::user()->id;
            }
        }

        $team->save();

        return redirect()->action('CourseController@getHoles');
    
    }



    /*
     * Join a number
     *
     */
    public function joinNumber(Request $request)
    {


        if(empty(Request::input('number'))){
            return Redirect::back()->withErrors(['join' => 'Please enter a number']);
        }

        $team = Team::where("number", Request::input('number'))->first();

        if(empty($team)){
            return Redirect::back()->withErrors(['join' => 'No team found with the number you entered']);
        }

        if(empty($team->id_user4)){
            if(empty($team->id_user3)){
                if(empty($team->id_user2)){
                    if(empty($team->id_user1)){
                        $team->id_user1 = Auth::user()->id;
                    }else{
                        $team->id_user2 = Auth::user()->id;
                    }
                }else{
                    $team->id_user3 = Auth::user()->id;
                }
            }else{
                $team->id_user4 = Auth::user()->id;
            }
        }else{
            return Redirect::back()->withErrors(['join' => 'The team number you entered is already full']);
        }

        $team->save();

        return redirect()->action('CourseController@getHoles');
    
    }


    public function notifications(Request $request)
    {
        $tournament = Tournament::where('active', '=', 1)->first();
        return view('notifications', [
            'notifications' => Notification::where('tournament_id', $tournament->id)->orderBy('id', 'DESC')->get(),       
        ]);
    }


    /*
     * Show the chirp page
     *
     */
    public function showChirp()
    {
        return view('chirp', [
            'allteams' => $this->team->getTeamListAll(),
            'myteam' => $this->team->getTeam()
        ]);
    }


}