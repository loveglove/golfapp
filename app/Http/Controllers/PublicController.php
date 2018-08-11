<?php

namespace App\Http\Controllers;

use App\Team;
use App\Score;
use App\Tournament;
use App\Notification;

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
        $tournament = Tournament::where('active', 1)->first();
        return view('leaderboard', [
            'standings' => $this->standings->getLeaderboard($tournament->id),
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
            $scores = $this->team->getCompleted($data['team_id']);

            $team = Team::find($data['team_id']);
            $mems = explode(',', $team->members);

            return ["scores" => $scores, "members" => $mems];
        }
        return 0;
    }


    // show active tournament notifcations for public view
    public function notifications(Request $request)
    {
        $tournament = Tournament::where('active', 1)->first();
        return view('publicnotifications', [
            'notifications' => Notification::where('tournament_id', $tournament->id)->orderBy('id', 'DESC')->get(),       
        ]);
    }

}
