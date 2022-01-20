<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analyses extends Model
{
    use HasFactory;

    protected $with = [
        'research_object'
    ];
    

    protected $fillable = [
        'analysis_name',
        'lead_time',
        'research_template',
        'price'
    ];

    public function research_object()
    {
        return $this->hasOne(Research_object::class, 'id', 'research_object_id');
    }
}
