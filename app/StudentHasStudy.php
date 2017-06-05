<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHasStudy extends Model
{
    //
    protected $fillable = [
        'student_id', 'field_id', 'semester_id', 'degree_id', 'study_form_id', 'average'
    ];
}
