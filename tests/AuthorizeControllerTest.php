<?php

namespace Sciice\Tests;

class AuthorizeControllerTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->authenticate();
    }

    public function test_get_authorize_index_data()
    {
        $response = $this->get_data();
        $response->assertOk();
        $this->assertEquals(12, count($response->original));
    }

    public function test_post_authorize_store_data()
    {
        $response = $this->post_data();
        $response->assertOk();

        $res = $this->get_data();
        $res->assertOk();
        $this->assertEquals(13, count($res->original));
        $this->assertEquals('test_authorize', $res->original[12]['name']);
    }

    public function test_update_authorize_data()
    {
        $this->post_data();
        $response = $this->putJson('/sciice/authorize/13', $this->arr_data('test_update_authorize'));
        $response->assertStatus(200);
        $res = $this->get_data();
        $this->assertEquals(13, count($res->original));
        $this->assertEquals('test_update_authorize', $res->original[12]['name']);
    }

    public function test_delete_authorize_fail_data()
    {
        $data = $this->postJson('/sciice/authorize', $this->arr_data('test_authorize', 1));
        $data->assertOk();
        $res = $this->get_data();
        $this->assertEquals(13, count($res->original));

        $response = $this->deleteJson('/sciice/authorize/1');
        $response->assertStatus(403);
    }

    public function test_delete_authorize_data()
    {
        $this->post_data();
        $response = $this->deleteJson('/sciice/authorize/13');
        $response->assertStatus(200);
        $res = $this->get_data();
        $this->assertEquals(12, count($res->original));
    }

    protected function get_data()
    {
        return $this->getJson('/sciice/authorize');
    }

    protected function post_data()
    {
        return $this->postJson('/sciice/authorize', $this->arr_data());
    }

    protected function arr_data($name = 'test_authorize', $parent = 0)
    {
        return [
            'name'     => $name,
            'title'    => 'test_authorize_title',
            'grouping' => 'sciice',
            'parent'   => $parent
        ];
    }
}
