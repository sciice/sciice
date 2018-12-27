<?php

namespace Sciice\Tests;

class SciiceControllerTest extends TestCase
{
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->authenticate();
    }

    public function test_get_sciice_index()
    {
        $response = $this->get_data();

        $response->assertJsonCount(3);
        $this->assertEquals(1, count($response->original));
        $response->assertStatus(200);
        $this->assertEquals($this->user->username, $response->original[0]['username']);
        $this->assertEquals($this->user->roles[0]['id'], $response->original[0]['roles'][0]['id']);
    }

    public function test_post_sciice_store_data()
    {
        $response = $this->post_data();

        $response->assertStatus(200);
        $res = $this->get_data();
        $res->assertJsonCount(3);
        $this->assertEquals(2, count($res->original));
        $this->assertEquals('post_test', $res->original[1]['username']);
        $this->assertEquals(1, $res->original[1]['roles'][0]['id']);
    }

    public function test_path_sciice_update_data()
    {
        $this->post_data();
        $response = $this->putJson('/sciice/user/2', $this->arr_data('test_update'));
        $response->assertStatus(200);
        $res = $this->get_data();

        $this->assertEquals('test_update', $res->original[1]['name']);
        $this->assertEquals(1, $res->original[1]['roles'][0]['id']);
    }

    public function test_delete_sciice_delete_data()
    {
        $this->post_data();

        $delete = $this->deleteJson('/sciice/user/1');
        $delete->assertStatus(403);
        $response = $this->deleteJson('/sciice/user/2');
        $response->assertStatus(200);
        $res = $this->get_data();
        $this->assertEquals(1, count($res->original));
    }


    protected function get_data()
    {
        return $this->getJson('/sciice/user');
    }

    protected function post_data()
    {
        return $this->postJson('/sciice/user', $this->arr_data());
    }

    protected function arr_data($name = 'post_test')
    {
        return [
            'name'     => $name,
            'username' => 'post_test',
            'email'    => 'post_test@i.com',
            'mobile'   => 13000033333,
            'password' => '123456',
            'role'     => 1,
        ];
    }
}
