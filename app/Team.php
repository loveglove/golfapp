<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    //
    protected $table = 'teams';
    
    protected $fillable = ['id', 'id_tour', 'id_user1', 'id_user2', 'name'];


}
