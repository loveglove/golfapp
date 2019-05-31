<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{

    protected $table = 'scores';


    protected $fillable = ['id', 'id_team', 'id_tour', 'hole', 'par', 'score'];

   /*
    * Get the team that owns the score (not required!!).
    */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

}
