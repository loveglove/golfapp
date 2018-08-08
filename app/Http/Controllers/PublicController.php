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

class PublicController extends Controller
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

        $this->standings = $standings;
        $this->team = $team;
    }

    /*
     *  Get public standings view
     */
    public function getPublicBoard()
    {
        return view('leaderboard', [
            'standings' => $this->standings->getLeaderboard(26),
        ]);
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
