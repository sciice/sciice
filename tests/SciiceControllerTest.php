<?php
namespace Sciice\Tests;

class SciiceControllerTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function test_get_sciice_index()
    {
        $this->authenticate();

        $data = $this->json('GET', '/sciice/user');
//
//        $data->dump();

        $data->assertStatus(403);
    }

    public function test_post_sciice_store_data()
    {

    }

    public function test_path_sciice_update_data()
    {

    }

    public function test_delete_sciice_delete_data()
    {

    }
}
