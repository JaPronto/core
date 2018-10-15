<?php

namespace Tests;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Traits\HasApiResource;

abstract class DatabaseActiveTest extends TestCase
{
    use HasApiResource, DatabaseMigrations, DatabaseTransactions;
}