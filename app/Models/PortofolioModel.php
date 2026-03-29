<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortofolioModel extends Model
{
    protected $table = 'portofolio';

    protected $fillable = [
        'id',
        'category_id',
        'tech_stacks_id',
        'title',
        'description',
        'date'
    ];

    public function category()
    {
        $this->belongsTo(CategoriesModel::class, 'category_id', 'id');
    }

    public function tech_stack()
    {
        $this->belongsTo(CategoriesModel::class, 'tech_stacks_id', 'id');
    }
}
