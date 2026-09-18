<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['participant_name', 'score', 'total_questions'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
