<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserQuiz;
use App\Repositories\Quiz\QuizRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private QuizRepository $quizRepository;
    private UserRepository $userRepository;

    public function __construct(QuizRepository $_quizRepository, UserRepository $_userRepository)
    {
        $this->quizRepository = $_quizRepository;
        $this->userRepository = $_userRepository;
    }

    public function __invoke(Request $request)
    {
        $quizzes = $this->quizRepository->getAllQuiz(false);
        $users = $this->userRepository->getUser([
            'is_admin' => 0
        ], false);
        $userQuizzes = UserQuiz::orderBy('score', 'desc')->get();
        return view('admin.dashboard', compact('quizzes', 'users', 'userQuizzes'));
    }
}
