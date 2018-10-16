<?php

namespace Tests\Feature\SubOrganization;


class ReadTest extends SubOrganizationTest
{
    public function test_unauthenticated_users_can_read_sub_organizations()
    {
        $organization = $this->createSubOrganization();

        return $this->read()
            ->assertSeeText($organization->name)
            ->assertSeeText($organization->description)
            ->assertPaginationResource();
    }

    public function read()
    {
        return $this->makeGetRequest('index');
    }
}