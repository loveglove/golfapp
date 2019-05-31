<?php

namespace App\Repositories;

use Auth;
use App\User;
use App\Team;
use App\Score;
use DB;

/*  This repo is a series of functions 
    that can be run against eloquent 
    models to retirieve information 
    relevant to a team  */


class StandingsRepository
{

    public function getLeaderboard($tour)
    {
        return DB::select('call getLeaderBoard(?)', array($tour));
    }

    public function getSkinsBoard($team1, $team2, $tour)
    {
        return DB::select('call getSkinsBoard(?,?,?)', array($team1, $team2, $tour));
    }

    public function getMatchBoard($team1, $team2, $tour)
    {
        return DB::select('call getMatchBoard(?,?,?)', array($team1, $team2, $tour));
    }

    public function getStrokeBoard($team1, $team2, $tour)
    {
        return DB::select('call getStrokeBoard(?,?,?)', array($team1, $team2, $tour));
    }

    public function getHoleAverage($tour, $holes)
    {
        $averages = array();
        for($x = 1; $x <= $holes; $x++)
        {
            $result = DB::select(DB::raw("SELECT AVG(score) AS hole_avg FROM scores WHERE hole = '".$x."' AND id_tour = '".$tour."'"));

            array_push($averages, intval(round($result[0]->hole_avg)));
            
        } 
        return $averages;

    }


    public function getScoreAverage($tour)
    {
        $averages = array();
        for($x = 1; $x <= $holes; $x++)
        {
            $result = DB::select(DB::raw("SELECT AVG(score) AS hole_avg FROM scores WHERE hole = '".$x."' AND id_tour = '".$tour."'"));

            array_push($averages, intval(round($result[0]->hole_avg)));
            
        } 
        return $averages;

    }
}