<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code'
    ];

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function sub_organizations()
    {
        return $this->hasMany(SubOrganization::class);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

}
