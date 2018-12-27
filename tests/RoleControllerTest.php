<?php

namespace Sciice\Tests;

class RoleControllerTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->authenticate();
    }

    public function test_get_role_index_data()
    {
        $response = $this->get_data();
        $response->assertOk();
        $this->assertEquals(1, count($response->original));
    }

    public function test_post_role_store_data()
    {
        $response = $this->post_data();
        $response->assertOk();

        $res = $this->get_data();
        $this->assertEquals(2, count($res->original));
        $this->assertEquals('test_role', $res->original[1]['name']);
    }

    public function test_update_role_data()
    {
        $this->post_data();
        $response = $this->putJson('/sciice/role/2', $this->arr_data('test_update_role'));
        $response->assertStatus(200);
        $res = $this->get_data();
        $this->assertEquals(2, count($res->original));
        $this->assertEquals('test_update_role', $res->original[1]['name']);
    }

    public function test_delete_role_data()
    {
        $this->post_data();

        $delete = $this->deleteJson('/sciice/role/1');
        $delete->assertStatus(403);
        $response = $this->deleteJson('/sciice/role/2');
        $response->assertStatus(200);
        $res = $this->get_data();
        $this->assertEquals(1, count($res->original));
    }

    protected function get_data()
    {
        return $this->getJson('/sciice/role');
    }

    protected function post_data()
    {
        return $this->postJson('/sciice/role', $this->arr_data());
    }

    protected function arr_data($name = 'test_role')
    {
        return [
            'name'       => $name,
            'title'      => 'test_role_title',
            'guard_name' => 'sciice'
        ];
    }
}
