<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Image;
use App\Models\Group;
use Tests\TestCase;

class DockerImageControllerTest extends TestCase
{
    private $requiredFields = ["group_id", "label", "tag"];

    /**
     * A single docker image index page test
     *
     * @return void
     */
    public function testDockerImageList()
    {
        $dockerImage = Image::factory()->create([
            "label" => "Woot!",
            "tag" => "image:latest",
        ]);

        $response = $this->get(route('groups.edit', $dockerImage->group->id));
        $response->assertStatus(200);

        $response->assertSee("Woot!");
        $response->assertSee("image:latest");
    }

    /**
     * An group create test
     *
     * @return void
     */
    public function testDockerImageCreate()
    {
        $groupId = Group::factory()->create()->id;

        $response = $this->get(route('groups.docker_images.create', $groupId));
        $response->assertStatus(200);

        $response->assertSee('Image Label');
        $response->assertSee('Image Tag');
        $response->assertSee('Submit');
        $response->assertSee('name="label"', false);
        $response->assertSee('name="tag"', false);
        $response->assertSee('type="submit"', false);
    }

    /**
     * An docker image store test
     *
     * @return void
     */
    public function testDockerImageStore()
    {
        $groupId = Group::factory()->create()->id;

        $response = $this->post(route('groups.docker_images.store', $groupId), [
            "group_id" => $groupId,
            "label" => "Foo!",
            "tag" => "bar",
        ]);

        $response->assertStatus(302);
        $this->assertEquals(1, Image::count());

        $dockerImage = Image::findOrFail(1);

        $this->assertEquals($groupId, $dockerImage->group_id);
        $this->assertEquals("Foo!", $dockerImage->label);
        $this->assertEquals("bar", $dockerImage->tag);
        $this->assertEquals("foo", $dockerImage->slug);
    }

    /**
     * An docker image edit test
     *
     * @return void
     */
    public function testDockerImageEdit()
    {
        $dockerImage = Image::factory()->create();

        $response = $this->get(route('groups.docker_images.edit', [$dockerImage->group->id, $dockerImage->id]));

        $response->assertStatus(200);

        $response->assertSee('Image Label');
        $response->assertSee('Image Tag');
        $response->assertSee('Submit');
        $response->assertSee('name="label"', false);
        $response->assertSee('value="'.$dockerImage->label.'"', false);
        $response->assertSee('name="tag"', false);
        $response->assertSee('value="'.$dockerImage->tag.'"', false);
        $response->assertSee('type="submit"', false);
    }

    /**
     * An docker image update test
     *
     * @return void
     */
    public function testDockerImageUpdate()
    {
        $dockerImage = Image::factory()->create();

        $response = $this->put(route('groups.docker_images.update', [$dockerImage->group->id, $dockerImage->id]), [
            "group_id" => $dockerImage->group->id,
            "label" => "Foo!",
            "tag" => "nginx:latest",
        ]);

        $response->assertStatus(302);

        $dockerImage = Image::findOrFail(1);

        $this->assertEquals("Foo!", $dockerImage->label);
        $this->assertEquals("nginx:latest", $dockerImage->tag);
        $this->assertEquals("foo", $dockerImage->slug);
    }

    /**
     * An docker image destroy test
     *
     * @return void
     */
    public function testDockerImageDestroy()
    {
        $dockerImage = Image::factory()->create();

        $this->assertEquals(1, Image::count());

        $response = $this->delete(route('groups.docker_images.destroy', [$dockerImage->group->id, $dockerImage->id]));

        $response->assertStatus(302);

        $this->assertEquals(0, Image::count());
    }

    /**
     * A docker image required validation test
     *
     * @return void
     */
    public function testDockerImageRequiredValidations()
    {
        foreach($this->requiredFields as $requiredField) {
            $dockerImage = Image::factory()->make();

            $groupId = $dockerImage->group->id;

            // Fail creation
            $value = $dockerImage->{$requiredField};
            $dockerImage->{$requiredField} = "";
            $response = $this->post(route('groups.docker_images.store', $groupId), $dockerImage->toArray());

            // Assert creation failure
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                $requiredField => "The ".str_replace("_", " ", $requiredField)." field is required.",
            ]);

            if(is_null(Image::first())) {
                $dockerImage = Image::factory()->create([
                    'group_id' => $groupId,
                ]);
            }
            $dockerImage = Image::first();
            $dockerImage->{$requiredField} = $value;

            // Fail update
            $value = $dockerImage->{$requiredField};
            $dockerImage->{$requiredField} = "";
            $response = $this->put(route('groups.docker_images.update', [$groupId, $dockerImage->id]), $dockerImage->toArray());

            // Assert update failure
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                $requiredField => "The ".str_replace("_", " ", $requiredField)." field is required.",
            ]);
        }
    }
}
