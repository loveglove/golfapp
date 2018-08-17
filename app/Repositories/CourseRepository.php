<?php

namespace App\Repositories;

use App\Course;
use App\Hole;
use App\Tournament;

class CourseRepository
{
    /**
     * Get all of the holes for a given course.
     *
     * @param  Hole class
     * @return Collection
     */
    public function getCourse()
    {
        $tournament = Tournament::where('active', 1)->first();
        return Hole::where('id_course', $tournament->id_course)->get();
    }


}