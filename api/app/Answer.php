<?php

namespace App;

use App\Filters\Traits\Filter;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use Filter;

    protected $fillable = [
        'value', 'is_true', 'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getIsTrueAttribute()
    {
        return (bool) $this->attributes['is_true'];
    }
}
