<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\App;
use Tests\TestCase;

class AppTest extends TestCase
{
    private $requiredFields = ["title", "fs_path", "url"];
    
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
        $response->assertRedirect(route('apps.index'));
        
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
        $response->assertSee('value="Woot!"', false);
        $response->assertSee('name="url"', false);
        $response->assertSee('value="/tmp"', false);
        $response->assertSee('name="fs_path"', false);
        $response->assertSee('value="woot"', false);
        $response->assertSee('type="submit"', false);
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
        $response->assertRedirect(route('apps.index'));
        
        $app = App::findOrFail(1);

        $this->assertEquals("Foo!", $app->title);
        $this->assertEquals("/tmp/changed", $app->fs_path);
        $this->assertEquals("bar", $app->url);
        $this->assertEquals("foo", $app->slug);
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
        $response->assertRedirect(route('apps.index'));
        
        $this->assertEquals(0, App::count());
    }

    /**
     * An app required validation test
     *
     * @return void
     */
    public function testAppRequiredValidations()
    {
        foreach($this->requiredFields as $requiredField) {
            $app = App::factory()->make();

            // Fail creation
            $value = $app->{$requiredField};
            $app->{$requiredField} = "";
            $response = $this->post(route('apps.store'), $app->toArray());

            // Assert creation failure
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                $requiredField => "The ".str_replace("_", " ", $requiredField)." field is required.",
            ]);

            $app->{$requiredField} = $value;
            $app = App::create($app->toArray());

            // Fail update
            $value = $app->{$requiredField};
            $app->{$requiredField} = "";
            $response = $this->put(route('apps.update', $app->id), $app->toArray());

            // Assert update failure
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                $requiredField => "The ".str_replace("_", " ", $requiredField)." field is required.",
            ]);
        }
    }
}
