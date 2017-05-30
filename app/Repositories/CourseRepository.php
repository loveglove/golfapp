<?php

namespace App\Repositories;

use App\Course;
use App\Hole;
use Session;

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
        $course = Session::get('tournament')->id_course;
        return Hole::where('id_course','=', $course)->get();
    }


}