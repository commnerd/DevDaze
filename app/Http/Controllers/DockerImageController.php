<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\DockerImage;
use App\Models\App;

class DockerImageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function create(App $app): Response
    {
        return response()->view('apps.docker_images.create', compact('app'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, App $app): RedirectResponse
    {
        $this->validate($request, (new DockerImage)->validations());

        $app->docker_images()->create($request->all());

        return redirect()->route('apps.edit', compact('app'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\App  $app
     * @param  \App\Models\DockerImage  $dockerImage
     * @return \Illuminate\Http\Response
     */
    public function edit(App $app, DockerImage $docker_image): Response
    {
        return response()->view('apps.docker_images.edit', compact('app', 'docker_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\App  $app
     * @param  \App\Models\DockerImage  $dockerImage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, App $app, DockerImage $docker_image): RedirectResponse
    {
        $this->validate($request, $docker_image->validations());

        // Purge the slug for regeneration per https://github.com/cviebrock/eloquent-sluggable#onupdate
        $docker_image->slug = null;
        $docker_image->update($request->all());

        return redirect()->route('apps.edit', compact('app'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\App  $app
     * @param  \App\Models\DockerImage  $dockerImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app, DockerImage $dockerImage)
    {
        $dockerImage->delete();

        return redirect()->route('apps.edit', $app->id);
    }
}
