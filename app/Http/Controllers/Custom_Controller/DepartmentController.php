<?php

namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Events\ModuleCreated;
use App\Http\Requests\StoreDepartmentRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentController extends Controller
{
    protected $departmentRepo;

    public function __construct(DepartmentRepositoryInterface $departmentRepo)
    {
        $this->middleware('auth');
        $this->departmentRepo=$departmentRepo;

         $this->middleware(function ($request, $next) {
                if (!has_role('admin')) {
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
            $department = Department::onlyTrashed()->get();
            return view('departments.restored', compact('department'));
        }
        else
        {
            $departments = $this->departmentRepo->all();
            return view('departments.index', compact('departments'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();
        $department=$this->departmentRepo->create($data);
        event(new ModuleCreated($department, 'department'));


        return redirect()->route('departments.index')->with('success', 'Department added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $department = $this->departmentRepo->find($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepartmentRequest $request,$id)
    {
        $department = $this->departmentRepo->find($id);

        $data = $request->validated();

        $department->fill($data); 
        $department->save(); 

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->departmentRepo->delete($id);

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

     public function restore($id)
    {
        $this->departmentRepo->restore($id);
        return redirect()->route('departments.index');

    }

    public function forceDeleted($id)
    {
        $this->departmentRepo->forceDelete($id);
        return redirect()->route('departments.index');
    }

    public function trashedData(Request $request)
    {
        $data = Department::onlyTrashed()->select(['id', 'name','deleted_at']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('restore', function ($row) {
                $url = route('departments.restore', $row->id);
                return '<form method="POST" action="' . $url . '">' .
                    csrf_field() .
                    method_field('PATCH') .
                    '<button class="btn btn-success btn-sm">Restore</button></form>';
            })
            ->addColumn('forceDelete', function ($row) {
                $url = route('departments.forceDeleted', $row->id);
                return '<form method="POST" action="' . $url . '">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button class="btn btn-danger btn-sm">ForceDelete</button></form>';
            })
            ->rawColumns([ 'restore', 'forceDelete' ])
            ->make(true);
    }
}
