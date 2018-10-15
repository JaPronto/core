<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubOrganization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'founded_at',
        'description',
        'country_id',
        'organization_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
