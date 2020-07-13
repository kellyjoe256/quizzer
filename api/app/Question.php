<?php

namespace App;

use App\Filters\Traits\Filter;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Filter;

    protected $fillable = [
        'text', 'quiz_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
