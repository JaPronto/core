<?php

namespace App\Repositories;


use App\Country;

class CountryRepository extends BaseRepository
{
    protected $model = Country::class;

    public function findByCode($code, $fail = true)
    {
        $query = $this->newQuery()
            ->where('code', $code);

        if ($fail) return $query->firstOrFail();

        return $query->first();
    }
}