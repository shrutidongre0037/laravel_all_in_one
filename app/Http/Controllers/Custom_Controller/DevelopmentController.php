<?php

namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use App\Models\Development;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreDevelopmentRequest;


class DevelopmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'hr' && Auth::user()->role !== 'development') {
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
        return view('developments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDevelopmentRequest $request)
    {
        $data = $request->validated();

         if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('developments', 'public');
        }

        Development::create($data);

        return redirect()->route('developments.index')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Development $development)
    {
        return view('developments.show', compact('development'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Development $development)
    {
        return view('developments.edit', compact('development'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDevelopmentRequest $request, Development $development)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($development->image) {
                Storage::disk('public')->delete($development->image);
            }

            $data['image'] = $request->file('image')->store('developments', 'public');
        }

        $development->update($data);

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
            $development = Development::select(['id','name', 'email', 'phone', 'address', 'image']);

            return DataTables::of($development)
            ->addIndexColumn()
                ->addColumn('image', function($row) {
                    return '<img src="' . asset('storage/' . $row->image) . '" width="60" height="90">';
                })
                ->addColumn('edit', function($row) {
                    return '<a href="' . route('developments.edit', $row->id) . '" class="btn   btn-primary">Edit</a>';
                })
                ->addColumn('delete', function($row) {
                    return '<a href="' . route('developments.index', $row->id) . '" class="btn  btn-danger">Delete</a>';
                })
                ->addColumn('view', function($row) {
                    return '<a href="' . route('developments.show', $row->id) . '" class="btn   btn-warning">View</a>';
                })
                ->rawColumns(['image', 'edit', 'delete', 'view'])
                ->make(true);
        }
    }
}
