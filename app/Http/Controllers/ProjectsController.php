<?php

namespace App\Http\Controllers;

use App\Project;
use App\Http\Resources\Project as ProjectResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Project::class);

        return ProjectResource::collection(request()->user()->projects);
    }

    public function store()
    {
        $this->authorize('create', Project::class);

        $project = request()->user()->projects()->create($this->validateData());

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return new ProjectResource($project);
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateData());

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData(){
        return request()->validate([
            'name' => 'required',
            'company' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);
    }
}
