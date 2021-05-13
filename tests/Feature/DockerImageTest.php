<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\DockerImage;
use App\Models\App;
use Tests\TestCase;

class DockerImageTest extends TestCase
{
    /**
     * A single docker image index page test
     *
     * @return void
     */
    public function testDockerImageList()
    {
        $dockerImage = DockerImage::factory()->create([
            "label" => "Woot!",
            "tag" => "image:latest",
        ]);

        $response = $this->get(route('apps.edit', $dockerImage->app->id));

        $response->assertStatus(200);

        $response->assertSee("Woot!");
        $response->assertSee("image:latest");
    }

    /**
     * An app create test
     *
     * @return void
     */
    public function testDockerImageCreate()
    {
        $appId = App::factory()->create()->id;

        $response = $this->get(route('apps.docker_images.create', $appId));

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
        $appId = App::factory()->create()->id;

        $response = $this->post(route('apps.docker_images.store', $appId), [
            "app_id" => $appId,
            "label" => "Foo!",
            "tag" => "bar",
        ]);

        $response->assertStatus(302);
        $this->assertEquals(1, DockerImage::count());

        $dockerImage = DockerImage::findOrFail(1);

        $this->assertEquals($appId, $dockerImage->app_id);
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
        $dockerImage = DockerImage::factory()->create();

        $response = $this->get(route('apps.docker_images.edit', [$dockerImage->app->id, $dockerImage->id]));

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
        $dockerImage = DockerImage::factory()->create();

        $response = $this->put(route('apps.docker_images.update', [$dockerImage->app->id, $dockerImage->id]), [
            "app_id" => $dockerImage->app->id,
            "label" => "Foo!",
            "tag" => "nginx:latest",
        ]);

        $response->assertStatus(302);
        
        $dockerImage = DockerImage::findOrFail(1);

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
        $dockerImage = DockerImage::factory()->create();

        $this->assertEquals(1, DockerImage::count());

        $response = $this->delete(route('apps.docker_images.destroy', [$dockerImage->app->id, $dockerImage->id]));

        $response->assertStatus(302);
        
        $this->assertEquals(0, DockerImage::count());
    }
}