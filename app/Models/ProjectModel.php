<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectModel extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'id',
        'category_id',
        'title',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function tech_stacks_project(): BelongsToMany
    {
        return $this->belongsToMany(TechStackModel::class, 'tech-stack_project', 'project_id', 'tech_stack_id');
    }
}
