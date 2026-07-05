<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $table = 'portofolio';

    protected $fillable = [
        'id',
        'category_id',
        'tech_stacks_id',
        'title',
        'description',
    ];

    public function category()
    {
        $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function tech_stack()
    {
        $this->belongsTo(TechStackModel::class, 'tech_stacks_id', 'id');
    }
}
