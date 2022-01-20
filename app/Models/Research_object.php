<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research_object extends Model
{
    use HasFactory;

    protected $fillable = [
        'research_object',
        'cost_of_taking',
    ];

    public function analyses()
    {
        return $this->hasMany(Analyses::class, 'research_object_id', 'id');
    }
}
