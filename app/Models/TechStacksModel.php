<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechStacksModel extends Model
{
    protected $table = 'tech-stacks';

    protected $fillable = [
        'id',
        'name',
        'techStack_code'
    ];
}
