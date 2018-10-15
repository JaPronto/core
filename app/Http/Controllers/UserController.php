<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ViewUserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ViewUserRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return void
     */
    public function store(CreateUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @param ShowUserRequest $request
     * @return void
     */
    public function show(User $user, ShowUserRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  \App\User $user
     * @return void
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteUserRequest $request
     * @param  \App\User $user
     * @return void
     */
    public function destroy(DeleteUserRequest $request,User $user)
    {
        //
    }
}
