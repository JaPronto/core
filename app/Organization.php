<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes, Sluggable;

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

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
          'slug' => [
              'source' => 'name'
          ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
