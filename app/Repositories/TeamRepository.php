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

    public function getScoreAny($team_id, $tour_id)
    {
        $scoreTotal = DB::table('scores')->where('id_team','=', $team_id)->where('id_tour','=', $tour_id)->sum('score');
        $parTotal = DB::table('scores')->where('id_team','=', $team_id)->where('id_tour','=', $tour_id)->sum('par');
        return $scoreTotal - $parTotal;
    }

    public function getCompleted($team_id)
    {
        // $id_tour = Session::get('tournament')->id;
        return Score::where('id_team', '=', $team_id)->get();
    }

    public function getCompletedValues($team_id)
    {
        $values = array();
        $scores = Score::where('id_team', '=', $team_id)->get();
        foreach($scores  as $s)
        {
            array_push($values, $s->score);
        }
        return $values;
    }

    public function getMatchups()
    {

        $tournament = Session::get('tournament');
        return Matchup::where('id_tour','=', $tournament->id)->get();

    }

    public function getStatistics()
    {
        $team = $this->getTeam();
        $scores = Score::where('id_team', $team->id)->get();
        
        $holeinones = 0;
        $albatrosses = 0;
        $eagles = 0;
        $birdies = 0;
        $pars = 0;
        $bogeys = 0;
        $doublebogeys = 0;

        foreach($scores as $score)
        {
            $v = $score->score;
            $p = $score->par;
            
            if($v == 1){
                $holeinones++;
            }elseif($v == ($p - 3) && !(($p - 3) == 1)){
                $albatrosses++;
            }elseif($v == ($p - 2) && !(($p - 2) == 1)){
                $eagles++;
            }elseif($v == ($p - 1)){
                $birdies++;
            }elseif($v == $p){
                $pars++;
            }elseif($v == ($p + 1)){
                $bogeys++;
            }elseif($v == ($p + 2)){
                $doublebogeys++;
            }
        }

        $statistics = [
            'holeinones'=>$holeinones,
            'albatrosses'=>$albatrosses,
            'eagles'=>$eagles,
            'birdies'=>$birdies,
            'pars'=>$pars,
            'bogeys'=>$bogeys,
            'doublebogeys'=>$doublebogeys
        ];

        return $statistics;

    }

    public function getTourAverage()
    {
        $scores = array();
        $tournament = Session::get('tournament');
        $teams = $this->getAllTeams();
        foreach($teams as $team)
        {
            $score = $this->getScoreAny($team->id, $tournament->id);
            array_push($scores, intval($score));
        }
        return ceil(array_sum($scores) / count($scores));
    }
}