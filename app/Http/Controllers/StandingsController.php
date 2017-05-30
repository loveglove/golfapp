<?php

namespace App\Http\Controllers;

use App\Team;
use App\Score;
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
        $type = Session::get('tournament')->type;
        switch($type){
                case 'traditional':
                    $tournament = Session::get('tournament');
                    return view('traditional', [
                        'standings' => $this->standings->getLeaderboard($tournament->id),
                    ]);
                break;

                case 'skins':
                    $tournament = Session::get('tournament');
                    $allmatchups = $this->team->getMatchups();
                    $standings = array();
                    foreach($allmatchups as $matchup){
                        $result = $this->standings->getSkinsBoard($matchup->id_team1, $matchup->id_team2, $tournament->id);
                        array_push($standings, $result);
                    }  
                    return view('skins', [
                        'standings' => $standings
                    ]);
                break;

                case 'stroke':
                    $tournament = Session::get('tournament');
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
                    $tournament = Session::get('tournament');
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
            return $this->team->getCompleted($data['team_id']);
        }
        return 0;
    }


}
