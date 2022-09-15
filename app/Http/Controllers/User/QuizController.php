<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Quiz\QuizRepository;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    private QuizRepository $quizRepository;

    public function __construct(QuizRepository $_quizRepository)
    {
        $this->quizRepository = $_quizRepository;
    }

    public function index(Request $request): View
    {
        $quizzes = $this->quizRepository->getAllQuiz(false);
        return view('user.quiz.index', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $quizzes = $this->quizRepository->getAllQuiz(false);
        $answers = $request->answer;
        $uncheckedQuiz = $quizzes->filter(function ($value) use ($answers) {
            return !in_array($value->getKey(), array_keys($answers));
        });

        foreach ($uncheckedQuiz as $unchecked) {
            $answers[$unchecked->getKey()] = null;
        }

        $score = 0;
        foreach ($answers as $key => $value) {
            $quiz = $quizzes->where('id', $key)
                ->first();

            if (is_null($value)) {
                continue;
            }

            if ($quiz->correct_answer['answer_id'] == $value) {
                $score += $quiz->score;
            }
        }

        $user = auth()->user();

        DB::beginTransaction();
        try {
            $user->quiz()->create([
                'score' => $score
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            reportError($e->getMessage());
            dd($e->getMessage());
        }

        return redirect()->route('user.dashboard');
    }
}
