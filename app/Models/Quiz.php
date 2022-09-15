<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question',
        'answer',
        'score'
    ];

    protected $appends = [
        'correct_answer',
        'random_answer',
    ];

    protected $casts = [
        'answer' => 'array',
    ];

    public function getCorrectAnswerAttribute()
    {
        $answer = $this->answer;

        if (is_string($this->answer)) {
            $answer = json_decode($this->answer, true);
        }

        return collect($answer)->filter(function ($value, $key) {
            return $value['is_answer'];
        })->first();
    }

    public function getRandomAnswerAttribute()
    {
        $answer = $this->answer;

        if (is_string($this->answer)) {
            $answer = json_decode($this->answer, true);
        }

        $answer = collect($answer)->where('is_answer', false)->random(3);
        $answer->push($this->correct_answer);

        return $answer;
    }
}
