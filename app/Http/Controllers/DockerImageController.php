<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\BumpsService;
use App\Models\DockerImage;
use App\Models\Group;

class DockerImageController extends Controller
{
    use BumpsService;

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group): Response
    {
        return response()->view('groups.docker_images.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group): RedirectResponse
    {
        $this->validate($request, (new DockerImage)->validations());

        $group->docker_images()->create($request->all());

        return redirect()->route('groups.edit', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @param  \App\Models\DockerImage  $dockerImage
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group, DockerImage $docker_image): Response
    {
        return response()->view('groups.docker_images.edit', compact('group', 'docker_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @param  \App\Models\DockerImage  $dockerImage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group, DockerImage $docker_image): RedirectResponse
    {
        $this->validate($request, $docker_image->validations());

        // Purge the slug for regeneration per https://github.com/cviebrock/eloquent-sluggable#onupdate
        $docker_image->slug = null;
        $docker_image->update($request->all());

        return redirect()->route('groups.edit', compact('group'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @param  \App\Models\DockerImage  $dockerImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, DockerImage $dockerImage)
    {
        $dockerImage->delete();

        return redirect()->route('groups.edit', $group->id);
    }
}
