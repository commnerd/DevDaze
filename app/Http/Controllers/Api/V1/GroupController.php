<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, (new Group)->validations());

        return response()->json(Group::create($request->all()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Group $group): JsonResponse
    {
        $this->validate($request, (new Group)->validations());

        // Purge the slug for regeneration per https://github.com/cviebrock/eloquent-sluggable#onupdate
        $group->slug = null;

        return response()->json($group->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group): JsonResponse
    {
        return response()->json(["status" => $group->delete() ? "success" : "failed"]);
    }
}
