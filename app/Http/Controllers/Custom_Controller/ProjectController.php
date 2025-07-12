<?php

namespace App\Http\Controllers\Custom_controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if($request->deleted == 1)
        {
            $project = Project::onlyTrashed()->get();
            return view('projects.restored', compact('project'));

        }
        else
        {
         if ($request->ajax()) {
            $data = Project::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('edit', function($row) {
                    return '<a href="' . route('projects.edit', $row->id) . '" class="btn btn-primary">Edit</a>';
                })
                ->addColumn('delete', function($row) {
                    return '
                        <form method="POST" action="' . route('projects.destroy', $row->id) . '" onsubmit="return confirm(\'Are you sure?\')"   style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>';
                })
                ->addColumn('view', function($row) {
                    return '<a href="' . route('projects.show', $row->id) . '" class="btn btn-warning">View</a>';
                })
                ->rawColumns(['edit', 'delete', 'view'])
                ->make(true);
        }
        return view('projects.index');
    }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        Project::create($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
          return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
         $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }

    public function restore($id)
    {
        Project::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('projects.index')->with('success', 'Project restored.');
    }

     public function forceDeleted($id)
    {
        $project=Project::withTrashed()->find($id);
        $project->forceDelete();
        return redirect()->route('projects.index');
    }
   

}
