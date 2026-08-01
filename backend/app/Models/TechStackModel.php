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

    public function tech_stack_project()
    {
        return $this->belongsToMany(ProjectModel::class, 'tech-stack_project', 'tech_stack_id', 'project_id');
    }
}
