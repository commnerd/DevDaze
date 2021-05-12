<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\App;
use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * An empty app index page test.
     *
     * @return void
     */
    public function testEmptyAppList()
    {
        $response = $this->get(route('apps.index'));

        $response->assertStatus(200);

        $response->assertSee("No applications currently running.");
    }

    /**
     * A single app index page test
     *
     * @return void
     */
    public function testAppList()
    {
        App::factory()->create([
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $response = $this->get(route('apps.index'));

        $response->assertStatus(200);

        $response->assertSee("Woot!");
        $response->assertSee("woot");
    }

    /**
     * An app create test
     *
     * @return void
     */
    public function testAppCreate()
    {
        $response = $this->get(route('apps.create'));

        $response->assertStatus(200);

        $response->assertSee('Title');
        $response->assertSee('URL');
        $response->assertSee('File System Path');
        $response->assertSee('Submit');
        $response->assertSee('name="title"', false);
        $response->assertSee('name="url"', false);
        $response->assertSee('name="fs_path"', false);
        $response->assertSee('type="submit"', false);
    }

    /**
     * An app store test
     *
     * @return void
     */
    public function testAppStore()
    {
        $response = $this->post(route('apps.store'), [
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $response->assertStatus(302);
        
        $app = App::findOrFail(1);

        $this->assertEquals("Woot!", $app->title);
        $this->assertEquals("/tmp", $app->fs_path);
        $this->assertEquals("woot", $app->url);
        $this->assertEquals("woot", $app->slug);
    }

    /**
     * An app edit test
     *
     * @return void
     */
    public function testAppEdit()
    {
        App::factory()->create([
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $response = $this->get(route('apps.edit', 1));

        $response->assertStatus(200);

        $response->assertSee('Title');
        $response->assertSee('URL');
        $response->assertSee('File System Path');
        $response->assertSee('Submit');
        $response->assertSee('name="title"', false);
        $response->assertSee('name="url"', false);
        $response->assertSee('name="fs_path"', false);
        $response->assertSee('type="submit"', false);

        $response->assertSee('value="Woot!"', false);
        $response->assertSee('value="woot"', false);
    }

    /**
     * An app update test
     *
     * @return void
     */
    public function testAppUpdate()
    {
        App::factory()->create([
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $app = App::findOrFail(1);
        $this->assertEquals("Woot!", $app->title);
        $this->assertEquals("/tmp", $app->fs_path);
        $this->assertEquals("woot", $app->url);
        $this->assertEquals("woot", $app->slug);

        $response = $this->put(route('apps.update', 1), [
            "title" => "Foo!",
            "fs_path" => "/tmp/changed",
            "url" => "bar",
        ]);

        $response->assertStatus(302);
        
        $app = App::findOrFail(1);

        $this->assertEquals("Foo!", $app->title);
        $this->assertEquals("/tmp/changed", $app->fs_path);
        $this->assertEquals("bar", $app->url);
        $this->assertEquals("woot", $app->slug);
    }

    /**
     * An app destroy test
     *
     * @return void
     */
    public function testAppDestroy()
    {
        App::factory()->create();

        $this->assertEquals(1, App::count());

        $response = $this->delete(route('apps.destroy', 1));

        $response->assertStatus(302);
        
        $this->assertEquals(0, App::count());
    }
}
