<?php

namespace App\Services;


use App\Translation;

trait Translateable
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translateable');
    }
}