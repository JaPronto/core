<?php

namespace App\Repositories;


use App\User;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return parent::create($data);
    }
}