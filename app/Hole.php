<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hole extends Model
{
    //
    protected $table = 'holes';
    
    protected $guarded = [];

   /*
    * Get the course that owns the hole.
    */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
