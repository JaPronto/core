<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyTest extends UserTest
{


    public function destroy($userId)
    {
        return $this->makeDeleteRequest(['destroy', $userId]);
    }
}
