<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hole extends Model
{
    //
    protected $table = 'holes';
    
    protected $fillable = ['id', 'id_course', 'hole', 'par', 'blue', 'white', 'image', 'pin_lat', 'pin_lon'];

   /*
    * Get the course that owns the hole.
    */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
