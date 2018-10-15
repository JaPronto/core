<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ViewUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\User;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');

        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ViewUserRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ViewUserRequest $request)
    {
        return UserResource::collection($this->userRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return UserResource
     */
    public function store(CreateUserRequest $request)
    {
        return new UserResource($this->userRepository->create($request->only([
            'name',
            'email',
            'password'
        ])));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @param ShowUserRequest $request
     * @return UserResource
     */
    public function show(User $user, ShowUserRequest $request)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  \App\User $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        return new UserResource($this->userRepository->updateByModel($user, $request->only([
            'name',
            'email',
            'password'
        ])));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteUserRequest $request
     * @param  \App\User $user
     * @return void
     * @throws \Exception
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        if ($this->userRepository->deleteByModel($user)) return response('', 200);

        abort(500);
    }
}
