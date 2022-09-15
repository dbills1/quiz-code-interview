<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use Illuminate\Support\Str;

class Answers extends Component
{
    public array $answer = [];

    public function mount($quiz = null)
    {
        $defaultAnswer = [
            ['answer_id' => (string) Str::orderedUuid(), 'text' => '', 'is_answer' => false]
        ];

        if (!is_null($quiz)) {
            $defaultAnswer = $quiz->answer;

            if (is_string($quiz->answer)) {
                $defaultAnswer = json_decode($quiz->answer, true);
            }
        }

        $this->answer = $defaultAnswer;
    }

    public function addAnswer()
    {
        $this->answer[] = ['answer_id' => (string) Str::orderedUuid(), 'text' => '', 'is_answer' => false];
    }

    public function removeAnswer(int $index)
    {
        if (count($this->answer) == 1) {
            return;
        }

        unset($this->answer[$index]);
        array_values($this->answer);
    }

    public function render()
    {
        return view('livewire.answer');
    }
}
