<?php

namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use App\Models\Development;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreDevelopmentRequest;
use App\Traits\ImageUploadTrait;
use App\Events\DevelopmentCreated;
use App\Models\Department;
use App\Models\Project;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Repositories\Interfaces\DevelopmentRepositoryInterface;

class DevelopmentController extends Controller
{
    protected $developmentRepo;

    public function __construct(DevelopmentRepositoryInterface $developmentRepo)
    {
        $this->middleware('auth');
        $this->developmentRepo = $developmentRepo;

        $this->middleware(function ($request, $next) {
            if (!has_role('admin', 'hr', 'development')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->deleted == 1) {
            $development = Development::onlyTrashed()->get();
            return view('developments.restored', compact('development'));
        } 
        else {
            $development = $this->developmentRepo->all();
            Debugbar::addMessage('Debugbar is working!');
            Debugbar::info(['deveopment' => auth()->user()]);
            return view('developments.index', compact('development'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $projects = Project::all();
        return view('developments.create', compact('departments', 'projects',));
    }

    /**
     * Store a newly created resource in storage.
     */
    use  ImageUploadTrait;
    public function store(StoreDevelopmentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'developments');
        }
        $development = $this->developmentRepo->create($data);
        // dump($request->all());
        //dd($data);
        //ddd($data);

        event(new DevelopmentCreated($development));

        return redirect()->route('developments.index')->with('success', 'Data created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $development = $this->developmentRepo->find($id);
        return view('developments.show', compact('development'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $development = $this->developmentRepo->find($id);
        $departments = Department::all(); 
        $projects = Project::all();
        return view('developments.edit', compact('development', 'departments', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDevelopmentRequest $request, $id)
    {
        $development = $this->developmentRepo->find($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $this->deleteImage($development->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'developments');
        }

        $development->fill($data);
        $development->save();

        if ($request->has('project_ids')) {
            $development->projects()->sync($request->project_ids);
        }
        return redirect()->route('developments.index')->with('success', 'Data updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->developmentRepo->delete($id);
        return redirect()->route('developments.index')->with('success', 'data deleted successfully.');
    }

    public function restore($id)
    {
        $this->developmentRepo->restore($id);
        return redirect()->route('developments.index');
    }

    public function forceDeleted($id)
    {
        $this->developmentRepo->forceDelete($id);
        return redirect()->route('developments.index');
    }

    public function getDevelopment(Request $request)
    {
        $development = Development::with(['department', 'projects'])
            ->select(['id', 'name', 'email', 'phone', 'address', 'image', 'department_id', 'updated_at'])
            ->orderBy('updated_at', 'desc');
        return DataTables::of($development)
            ->addColumn('projects', function ($row) {
                return $row->projects->pluck('title')->implode('<br>');
            })
            ->addIndexColumn()
            ->addColumn('department', function ($row) {
                return $row->department ? $row->department->name : 'N/A';
            })
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                $src = asset('storage/' . $row->image); // from accessor
                return '<img src="' . $src . '" width="60" height="90">';
            })
            ->addColumn('edit', function ($row) {
                return '<a href="' . route('developments.edit', $row->id) . '" class="btn   btn-primary">Edit</a>';
            })
            ->addColumn('delete', function ($row) {
                return '
                    <form method="POST" action="' . route('developments.destroy', $row->id) . '" style="display:inline;" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                ';
            })
            ->addColumn('view', function ($row) {
                return '<a href="' . route('developments.show', $row->id) . '" class="btn   btn-warning">View</a>';
            })
            ->rawColumns(['image', 'edit', 'delete', 'view'])
            ->make(true);
    }

    public function trashedData(Request $request)
    {
        if ($request->ajax()) {
            $data = Development::onlyTrashed()->with(['department', 'projects']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', fn($row) => $row->department->name ?? 'N/A')
                ->addColumn('projects', fn($row) => $row->projects->pluck('title')->implode(', '))
                ->addColumn('image', fn($row) => '<img src="' . asset('storage/' . $row->image) . '" width="60" class="rounded mx-auto">')
                ->addColumn('restore', function ($row) {
                    return '<form action="' . route('developments.restore', $row->id) . '" method="POST" onsubmit="return confirm(\'Restore this record?\')">'
                        . csrf_field() . method_field('PATCH') .
                        '<button class="btn btn-success btn-sm">Restore</button></form>';
                })

                ->addColumn('forceDelete', function ($row) {
                    return '<form action="' . route('developments.forceDeleted', $row->id) . '" method="POST" onsubmit="return confirm(\'Permanently delete this record?\')">'
                        . csrf_field() . method_field('DELETE') .
                        '<button class="btn btn-danger btn-sm">Delete</button></form>';
                })
                ->rawColumns(['image', 'restore', 'forceDelete'])
                ->make(true);
        }
    }
}
