<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $_repository)
    {
        $this->repository = $_repository;
    }

    public function index(): View
    {
        $users = $this->repository->getAllUser();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\User\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        try {
            $this->repository->save($data);
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        $user = $this->repository->getUserById($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): View
    {
        $user = $this->repository->getUserById($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\User\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $data = $request->validated();

        if (is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        try {
            $this->repository->update($id, $data);
            return redirect()->route('admin.users.index');
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
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function restore(int $id)
    {
        try {
            User::withTrashed()->find($id)->restore();
            return redirect()->route('admin.quizzes.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }
}
