<?php

namespace Tests\Feature\Auth;


use Tests\DatabaseActiveTest;

abstract class AuthTest extends DatabaseActiveTest
{

    protected function setUp()
    {
        parent::setUp();

        $this->installPassport();
    }

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'user';
    }
}