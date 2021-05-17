<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Group;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    private $requiredFields = ["title", "fs_path", "url"];

    /**
     * An empty group index page test.
     *
     * @return void
     */
    public function testEmptyGroupList()
    {
        $response = $this->get(route('groups.index'));

        $response->assertStatus(200);

        $response->assertSee("No groups.");
    }

    /**
     * A single group index page test
     *
     * @return void
     */
    public function testGroupList()
    {
        Group::factory()->create([
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $response = $this->get(route('groups.index'));
        $response->assertStatus(200);

        $response->assertSee("Woot!");
        $response->assertSee("woot");
    }

    /**
     * An group create test
     *
     * @return void
     */
    public function testGroupCreate()
    {
        $response = $this->get(route('groups.create'));

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
     * An group store test
     *
     * @return void
     */
    public function testGroupStore()
    {
        $response = $this->post(route('groups.store'), [
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('groups.index'));

        $group = Group::findOrFail(1);

        $this->assertEquals("Woot!", $group->title);
        $this->assertEquals("/tmp", $group->fs_path);
        $this->assertEquals("woot", $group->url);
        $this->assertEquals("woot", $group->slug);
    }

    /**
     * An group edit test
     *
     * @return void
     */
    public function testGroupEdit()
    {
        Group::factory()->create([
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $response = $this->get(route('groups.edit', 1));

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
     * An group update test
     *
     * @return void
     */
    public function testGroupUpdate()
    {
        Group::factory()->create([
            "title" => "Woot!",
            "fs_path" => "/tmp",
            "url" => "woot",
        ]);

        $group = Group::findOrFail(1);
        $this->assertEquals("Woot!", $group->title);
        $this->assertEquals("/tmp", $group->fs_path);
        $this->assertEquals("woot", $group->url);
        $this->assertEquals("woot", $group->slug);

        $response = $this->put(route('groups.update', 1), [
            "title" => "Foo!",
            "fs_path" => "/tmp/changed",
            "url" => "bar",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('groups.index'));

        $group = Group::findOrFail(1);

        $this->assertEquals("Foo!", $group->title);
        $this->assertEquals("/tmp/changed", $group->fs_path);
        $this->assertEquals("bar", $group->url);
        $this->assertEquals("foo", $group->slug);
    }

    /**
     * An group destroy test
     *
     * @return void
     */
    public function testGroupDestroy()
    {
        Group::factory()->create();

        $this->assertEquals(1, Group::count());

        $response = $this->delete(route('groups.destroy', 1));

        $response->assertStatus(302);
        $response->assertRedirect(route('groups.index'));

        $this->assertEquals(0, Group::count());
    }

    /**
     * An group required validation test
     *
     * @return void
     */
    public function testGroupRequiredValidations()
    {
        foreach($this->requiredFields as $requiredField) {
            $group = Group::factory()->make();

            // Fail creation
            $value = $group->{$requiredField};
            $group->{$requiredField} = "";
            $response = $this->post(route('groups.store'), $group->toArray());

            // Assert creation failure
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                $requiredField => "The ".str_replace("_", " ", $requiredField)." field is required.",
            ]);

            $group->{$requiredField} = $value;
            $group = Group::create($group->toArray());

            // Fail update
            $value = $group->{$requiredField};
            $group->{$requiredField} = "";
            $response = $this->put(route('groups.update', $group->id), $group->toArray());

            // Assert update failure
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                $requiredField => "The ".str_replace("_", " ", $requiredField)." field is required.",
            ]);
        }
    }
}
