<?php

namespace App\Http\Controllers\Custom_controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProjectRequest;
use App\Events\ModuleCreated;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectController extends Controller
{
        protected $projectRepo;
    /**
     * Display a listing of the resource.
     */
    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index(Request $request)
    {
        if ($request->deleted == 1) {
            $project = Project::onlyTrashed()->get();
            return view('projects.restored', compact('project'));
        } else {
            $statuses = collect([
            (object)['id' => 'pending', 'label' => 'Pending'],
            (object)['id' => 'In progress', 'label' => 'In Progress'],
            (object)['id' => 'completed', 'label' => 'Completed'],
        ]);

        $priorities = collect([
            (object)['id' => 'low', 'label' => 'Low'],
            (object)['id' => 'medium', 'label' => 'Medium'],
            (object)['id' => 'high', 'label' => 'High'],
        ]);
            $project = $this->projectRepo->all();
            return view('projects.index', compact('project','statuses','priorities'));

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = collect([
        (object)['id' => 'pending', 'label' => 'Pending'],
        (object)['id' => 'In progress', 'label' => 'In Progress'],
        (object)['id' => 'completed', 'label' => 'Completed'],
    ]);

    $priorities = collect([
        (object)['id' => 'low', 'label' => 'Low'],
        (object)['id' => 'medium', 'label' => 'Medium'],
        (object)['id' => 'high', 'label' => 'High'],
    ]);
        return view('projects.create',compact('statuses','priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $project = $this->projectRepo->create($data);   
        event(new ModuleCreated($project, 'project'));
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = $this->projectRepo->find($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $statuses = collect([
        (object)['id' => 'pending', 'label' => 'Pending'],
        (object)['id' => 'In progress', 'label' => 'In Progress'],
        (object)['id' => 'completed', 'label' => 'Completed'],
    ]);

    $priorities = collect([
        (object)['id' => 'low', 'label' => 'Low'],
        (object)['id' => 'medium', 'label' => 'Medium'],
        (object)['id' => 'high', 'label' => 'High'],
    ]);
        $project = $this->projectRepo->find($id);
        return view('projects.edit', compact('project','statuses','priorities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, $id)
    {
        $project = $this->projectRepo->find($id);
        $data = $request->validated();
        $project->fill($data);
        $project->save();
        return redirect()->route('projects.index')->with('success', 'Project updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->projectRepo->delete($id);
        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }

    public function restore($id)
    {
        $this->projectRepo->restore($id);
        return redirect()->route('projects.index')->with('success', 'Project restored.');
    }

    public function forceDeleted($id)
    {
        $this->projectRepo->forceDelete($id);
        return redirect()->route('projects.index');
    }

    public function getProject(Request $request)
    {
        if ($request->ajax()) {
                $data = Project::query()
                    ->orderBy('updated_at', 'desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('edit', function ($row) {
                        return '<a href="' . route('projects.edit', $row->id) . '" class="btn btn-primary">Edit</a>';
                    })
                    ->addColumn('delete', function ($row) {
                        return '
                        <form method="POST" action="' . route('projects.destroy', $row->id) . '" onsubmit="return confirm(\'Are you sure?\')"   style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>';
                    })
                    ->addColumn('view', function ($row) {
                        return '<a href="' . route('projects.show', $row->id) . '" class="btn btn-warning">View</a>';
                    })
                    ->rawColumns(['edit', 'delete', 'view'])
                    ->make(true);
            }
            return view('projects.index');
    }
    public function trashedData(Request $request)
    {
        $projects = Project::onlyTrashed()->select('*');

        return DataTables::of($projects)
            ->addIndexColumn()
            ->addColumn('restore', function ($row) {
            $url = route('projects.restore', $row->id);
            return '<form method="POST" action="' . $url . '">' .
                csrf_field() .
                method_field('PATCH') .
                '<button class="btn btn-success btn-sm">Restore</button></form>';
        })
        ->addColumn('delete', function ($row) {
            $url = route('projects.forceDeleted', $row->id);
            return '<form method="POST" action="' . $url . '">' .
                csrf_field() .
                method_field('DELETE') .
                '<button class="btn btn-danger btn-sm">ForceDelete</button></form>';
        })
            ->rawColumns(['restore', 'delete'])
            ->make(true);
    }

}
