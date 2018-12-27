<?php

namespace Sciice\Tests;

use Sciice\Model\Sciice;

class LoginTest extends TestCase
{
    public function test_login_successful()
    {
        factory(Sciice::class)->create();

        $list = $this->json('POST', '/sciice/login', [
            'username' => 'test',
            'password' => '12345'
        ]);

        $list->assertOk();
    }

    public function test_login_validate_rule()
    {
        factory(Sciice::class)->create();
        $list = $this->json('POST', '/sciice/login', [
            'username' => 'test',
            'password' => '123'
        ]);

        $list->assertStatus(422);
    }
}
