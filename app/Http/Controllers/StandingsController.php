<?php

namespace App\Http\Controllers;

use App\Team;
use App\Score;
use App\Tournament;
use App\Award;
use Request;
use Input;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\StandingsRepository;
use App\Repositories\TeamRepository;

class StandingsController extends Controller
{
    /*
     * Repository instance.
     */

    protected $standings;
    protected $team;
    /*
     * Create a new controller instance.
     */
    public function __construct(StandingsRepository $standings, TeamRepository $team)
    {
        $this->middleware('auth');
        $this->standings = $standings;
        $this->team = $team;
    }



    /*
     * Get the tournament Standings
     *
     */
    public function getStandings(Request $request)
    {
        $URLpath = Request::getPathInfo();
        $tournament = null;
        $type = null;

        if($URLpath == "/lastyear"){
            $tournament = Tournament::find(31);
            $type = $tournament->type;
        }else{
            $tournament = Tournament::where('active', 1)->first();
            $type = $tournament->type;
        }
            
        switch($type){

            case 'traditional':
                return view('traditional', [
                    'standings' => $this->standings->getLeaderboard($tournament->id),
                    'tournament' => $tournament,
                    'team' => $this->team->getTeam(),
                    'cpm' => Award::where('id_tour', $tournament->id)->where('type', 'cpm')->latest()->first(),
                    'ldm' => Award::where('id_tour', $tournament->id)->where('type', 'ldm')->latest()->first(),
                    'cpw' => Award::where('id_tour', $tournament->id)->where('type', 'cpw')->latest()->first(),
                    'ldw' => Award::where('id_tour', $tournament->id)->where('type', 'ldw')->latest()->first(),
                ]);
            break;

            case 'skins':
                $allmatchups = $this->team->getMatchups();
                $standings = array();
                foreach($allmatchups as $matchup){
                    $result = $this->standings->getSkinsBoard($matchup->id_team1, $matchup->id_team2, $tournament->id);
                    array_push($standings, $result);
                }  
                return view('skins', [
                    'standings' => $standings,

                ]);
            break;

            case 'stroke':
                $allmatchups = $this->team->getMatchups();
                $standings = array();
                foreach($allmatchups as $matchup){
                    $result = $this->standings->getStrokeBoard($matchup->id_team1, $matchup->id_team2, $tournament->id);
                    array_push($standings, $result);
                }
                return view('stroke', [
                    'standings' => $standings
                ]);
            break;

            case 'match':
                $allmatchups = $this->team->getMatchups();
                $standings = array();
                foreach($allmatchups as $matchup){
                    $result = $this->standings->getMatchBoard($matchup->id_team1, $matchup->id_team2, $tournament->id);
                    array_push($standings, $result);
                }
                return view('match', [
                    'standings' => $standings
                ]);
            break;

        }

    }

    /*
     * Get Team score card
     *
     */
    public function getScoreCard(Request $request)
    {
        if(Request::ajax()) {
            $data = Request::all();
            $scores = $this->team->getCompleted($data['team_id']);

            $team = Team::find($data['team_id']);
            $mems = explode(',', $team->members);

            return ["scores" => $scores, "members" => $mems];
        }
        return 0;
    }


}
