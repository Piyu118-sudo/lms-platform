<?php

use App\Models\Course;
use App\Models\CoursePoilcy;

protected $policies = [
  Courses::class => CoursePolicy::class,
];
