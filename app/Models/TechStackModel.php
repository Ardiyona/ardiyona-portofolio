<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechStackModel extends Model
{
    protected $table = 'tech-stacks';

    protected $fillable = [
        'id',
        'name',
        'code'
    ];
}
