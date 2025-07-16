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

class DevelopmentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');

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
        if($request->deleted == 1)
        {
            $development = Development::onlyTrashed()->get();
            return view('developments.restored', compact('development'));

        }
        else
        {
            $development = Development::all();
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

        return view('developments.create',compact('departments','projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    use  ImageUploadTrait;
    public function store(StoreDevelopmentRequest $request)
    {
        $data = $request->validated();

         if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'),'developments');     
        }
        $development = Development::create($data);
            // dump($request->all());
            //dd($data);
            //ddd($data);

        if ($request->has('project_ids')) 
        {
            $development->projects()->sync($request->project_ids);
        }

        event(new DevelopmentCreated($development));

        return redirect()->route('developments.index')->with('success', 'Data created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Development $development)
    {
        $development->load(['department', 'projects']);
        return view('developments.show', compact('development'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Development $development)
    {
        $departments = Department::all(); // <-- this is missing
        $projects = Project::all(); 
        return view('developments.edit', compact('development','departments','projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDevelopmentRequest $request, Development $development)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($development->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'developments');
        }

        // Fill validated data
        $development->fill($data);

        // Save updated fields
        $development->save();

        // Sync project_ids if present
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
        $development = Development::findOrFail($id);
        $development->delete();

        return redirect()->route('developments.index')->with('success', 'data deleted successfully.');
    }

    public function restore($id)
    {
        $development=Development::onlyTrashed()->find($id)->restore();
        return redirect()->route('developments.index');

    }

    public function forceDeleted($id)
    {
        $development=Development::withTrashed()->find($id);
        $development->forceDelete();
        return redirect()->route('developments.index');
    }

     public function getDevelopment(Request $request)
    {
        if ($request->ajax()) {
            $development = Development::with(['department', 'projects'])->select([
    'id', 'name', 'email', 'phone', 'address', 'image', 'department_id'
]);
        return DataTables::of($development)
        ->addColumn('projects', function ($row) {
    return $row->projects->pluck('title')->implode('<br>');
})
            ->addIndexColumn()
            ->addColumn('department', function($row) {
                return $row->department ? $row->department->name : 'N/A';
            })
            ->addIndexColumn()
                ->addColumn('image', function($row) {
                    $src = asset('storage/' . $row->image); // from accessor
                    return '<img src="' . $src . '" width="60" height="90">';
                })
                ->addColumn('edit', function($row) {
                    return '<a href="' . route('developments.edit', $row->id) . '" class="btn   btn-primary">Edit</a>';
                })
                ->addColumn('delete', function($row) {
                return '
                    <form method="POST" action="' . route('developments.destroy', $row->id) . '" style="display:inline;" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                ';
                })
                ->addColumn('view', function($row) {
                    return '<a href="' . route('developments.show', $row->id) . '" class="btn   btn-warning">View</a>';
                })
                ->rawColumns(['image', 'edit', 'delete', 'view'])
                ->make(true);
        }

    }
}
