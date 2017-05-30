<?php

namespace App\Http\Controllers;
use Session;
use App\Team;
use App\Tournament;
use App\Matchup;
use Request;
use Auth;
use DB;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TeamRepository;


class MapController extends Controller
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
     * Get the map getAdminView
     */
    public function getMapView()
    {
        return view('map');

    }
}
