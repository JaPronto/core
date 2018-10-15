<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name',
      'founded_at',
      'country_id',
      'description',
      'image'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function sub_organizations()
    {
        return $this->hasMany(SubOrganization::class);
    }
}
