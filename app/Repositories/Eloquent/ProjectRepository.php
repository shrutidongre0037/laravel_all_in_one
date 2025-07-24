<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all()
    {
        return Project::all();
    }

     public function find($id)
    {
        return Project::findOrFail($id);
    }

    public function create(array $data)
    {
        $project = Project::create($data);
        return $project;
    }

    public function update($id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        return Project::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return Project::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id)
    {
        return Project::withTrashed()->findOrFail($id)->forceDelete();
    }

}
