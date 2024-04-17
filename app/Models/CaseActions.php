<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseActions extends Model
{
    protected $table = 'case_actions';
    public $timestamps = false;

    public $fillable = [
        'actions'        
    ];
}
