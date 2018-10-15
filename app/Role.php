<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'controlable'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }

    public function createRole($name)
    {
        return $this->create(compact('name'));
    }
}
