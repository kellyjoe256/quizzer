<?php

namespace App;

use App\Filters\Traits\Filter;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use Filter;

    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
