<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    
    /*
     *  Get all holes for the course.
     */
    public function holes()
    {
        return $this->hasMany(Hole::class);
    }
}
