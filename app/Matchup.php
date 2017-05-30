<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matchup extends Model
{
    protected $table = 'matchups';

    protected $fillable = ['id', 'id_tour', 'id_team1', 'id_team2', 'name1', 'name2', 'active'];
}
