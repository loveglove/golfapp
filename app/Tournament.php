<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = 'tournament';

    protected $fillable = ['id', 'id_course', 'name', 'date', 'active', 'type'];

}
