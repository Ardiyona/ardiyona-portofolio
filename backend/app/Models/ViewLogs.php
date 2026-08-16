<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewLogs extends Model
{
    protected $table = 'view_logs';

    protected $fillable = ['ip_address'];
}
