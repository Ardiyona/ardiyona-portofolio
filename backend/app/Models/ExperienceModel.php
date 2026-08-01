<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceModel extends Model
{
    protected $table = 'experiences';

    protected $fillable = [
        'position',
        'company',
        'location',
        'work_arrangement',
        'work_style',
        'is_currently_working',
        'work_start',
        'work_end',
    ];
}
