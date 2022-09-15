<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Quiz\StoreQuizRequest;
use App\Http\Requests\Admin\Quiz\UpdateQuizRequest;
use App\Models\Quiz;
use App\Repositories\Quiz\QuizRepository;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuizController extends Controller
{
    private QuizRepository $repository;

    public function __construct(QuizRepository $_repository)
    {
        $this->repository = $_repository;
    }

    public function index(): View
    {
        $quizzes = $this->repository->getAllQuiz();
        return view('admin.quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        $data = $request->validated();

        $scores = $this->repository->getScores();

        if ($scores + $data['score'] > 100) {
            return redirect()->back();
        }

        $answerThere = false;
        foreach ($data['answer'] as $index => $answer) {
            if (Arr::exists($answer, 'is_answer')) {
                $answerThere = true;
                $data['answer'][$index]['is_answer'] = true;
                continue;
            }

            $data['answer'][$index]['is_answer'] = false;
        }

        if (!$answerThere) {
            return redirect()->back();
        }

        $data['answer'] = json_encode($data['answer']);

        try {
            $this->repository->save($data);
            return redirect()->route('admin.quizzes.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        $quiz = $this->repository->getQuizById($id);
        return view('admin.quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): View
    {
        $quiz = $this->repository->getQuizById($id);
        return view('admin.quiz.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuizRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, int $id)
    {
        $data = $request->validated();
        $answerThere = false;

        $scores = $this->repository->getScores();
        $quiz = $this->repository->getQuizById($id);

        $totalScore = $scores + $data['score'] - $quiz->score;

        if ($totalScore > 100) {
            return redirect()->back();
        }

        foreach ($data['answer'] as $index => $answer) {
            if (Arr::exists($answer, 'is_answer')) {
                $answerThere = true;
                $data['answer'][$index]['is_answer'] = true;
                continue;
            }

            $data['answer'][$index]['is_answer'] = false;
        }

        if (!$answerThere) {
            return redirect()->back();
        }

        $data['answer'] = json_encode($data['answer']);

        try {
            $this->repository->update($id, $data);
            return redirect()->route('admin.quizzes.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->repository->delete($id);
            return redirect()->route('admin.quizzes.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function restore(int $id)
    {
        $scores = $this->repository->getScores();
        $quiz = $this->repository->getQuizById($id);

        $totalScore = $scores + $quiz->score;

        if ($totalScore > 100) {
            return redirect()->back();
        }

        try {
            $quiz->restore();
            return redirect()->route('admin.quizzes.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }
}
