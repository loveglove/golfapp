<?php

namespace App\Repositories;
use Session;
use Auth;
use App\User;
use App\Team;
use App\Score;
use App\Matchup;
use DB;

/*  This repo is a series of functions 
    that can be run against eloquent 
    models to retirieve information 
    relevant to a team  */


class TeamRepository
{

    public function getAllTeams()
    {
        $tournament = Session::get('tournament');
        return Team::where('id_tour', '=', $tournament->id)->get();
    }

    public function getTeamListOpen()
    {
        $tournament = Session::get('tournament');
        return Team::where('id_tour', '=', $tournament->id)->whereNull('id_user2')->lists('name', 'id');
    }

    public function getTeamListAll()
    {
        $tournament = Session::get('tournament');
        return Team::where('id_tour', '=', $tournament->id)->lists('name', 'id');
    }

    public function getTeam()
    {
        $tournament = Session::get('tournament');
        $id = Auth::user()->getId();
        return Team::where('id_tour', '=', $tournament->id)->where(function($query) use($id) {
            $query->where('id_user1', '=', $id)->orWhere('id_user2', '=', $id);
        })->first();
    }

    public function getUsers()
    {
        $team = $this->getTeam();
        $user1 = User::where('id', '=', $team->id_user1)->first();
        $user2 = User::where('id', '=', $team->id_user2)->first();
        return [$user1, $user2];
    }

    public function getScore()
    {
        $id_tour = Session::get('tournament')->id;
        $team = $this->getTeam();
        $scoreTotal = DB::table('scores')->where('id_team','=', $team->id)->where('id_tour','=', $id_tour)->sum('score');
        $parTotal = DB::table('scores')->where('id_team','=', $team->id)->where('id_tour','=', $id_tour)->sum('par');
        return $scoreTotal - $parTotal;

    }

    public function getCompleted($team_id)
    {
        // $id_tour = Session::get('tournament')->id;
        return Score::where('id_team', '=', $team_id)->get();
    }

    public function getMatchups()
    {

        $tournament = Session::get('tournament');
        return Matchup::where('id_tour','=', $tournament->id)->get();

    }
}