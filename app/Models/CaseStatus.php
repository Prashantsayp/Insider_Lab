<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStatus extends Model
{
    protected $table = 'case_status';
    public $timestamps = false;

    public $fillable = [
        'title',
        'is_active'        
    ];
}
