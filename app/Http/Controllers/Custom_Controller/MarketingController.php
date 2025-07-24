<?php

namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMarketingRequest;
use App\Traits\ImageUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use App\Events\ModuleCreated;
use App\Repositories\Interfaces\MarketingRepositoryInterface;


class MarketingController extends Controller
{
    protected $marketingRepo;

    public function __construct(MarketingRepositoryInterface $marketingRepo)
    {
        $this->middleware('auth');
        $this->marketingRepo=$marketingRepo;

        $this->middleware(function ($request, $next) {
            if (!has_role('admin', 'hr', 'marketing')) {
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
            $marketing = Marketing::onlyTrashed()->get();
            return view('marketings.restored', compact('marketing'));
        } else {
            $marketing = $this->marketingRepo->all();
            return view('marketings.index', compact('marketing'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marketings.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    use ImageUploadTrait;
    public function store(StoreMarketingRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'marketings');
        }

        $marketing = $this->marketingRepo->create($data);
        event(new ModuleCreated($marketing, 'Marketing'));
        return redirect()->route('marketings.index')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marketing = $this->marketingRepo->find($id);
        return view('marketings.show', compact('marketing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $marketing = $this->marketingRepo->find($id);
        return view('marketings.edit', compact('marketing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMarketingRequest $request, $id)
    {
        $marketing = $this->marketingRepo->find($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($marketing->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'marketings');
        }

        $marketing->fill($data);
        $marketing->save();

        return redirect()->route('marketings.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $this->marketingRepo->delete($id);
        return redirect()->route('marketings.index')->with('success', 'data deleted successfully.');
    }

    public function restore($id)
    {
        $this->marketingRepo->restore($id);
        return redirect()->route('marketings.index');
    }

    public function forceDeleted($id)
    {
        $this->marketingRepo->forceDelete($id);
        return redirect()->route('marketings.index');
    }

    public function getMarketing(Request $request)
    {
        if ($request->ajax()) {
            $marketing = Marketing::select(['id', 'name', 'email', 'phone', 'address', 'image'])
                ->orderBy('updated_at', 'desc');

            return DataTables::of($marketing)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = asset('storage/' . $row->image);
                    return '<img src="' . $src . '" width="60" height="60">';
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="' . route('marketings.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '
                    <form method="POST" action="' . route('marketings.destroy', $row->id) . '" style="display:inline;" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
                })
                ->addColumn('view', function ($row) {
                    return '<a href="' . route('marketings.show', $row->id) . '" class="btn btn-sm btn-warning">View</a>';
                })
                ->rawColumns(['image', 'edit', 'delete', 'view'])
                ->make(true);
        }

        return view('marketing.index');
    }
    public function trashedData(Request $request)
    {
        $data = Marketing::onlyTrashed()->select(['id', 'name', 'email', 'phone', 'address', 'image', 'deleted_at']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<img src="' . asset('storage/' . $row->image) . '" width="60" class="mx-auto rounded">';
            })
            ->addColumn('restore', function ($row) {
                $url = route('marketings.restore', $row->id);
                return '<form method="POST" action="' . $url . '">' .
                    csrf_field() .
                    method_field('PATCH') .
                    '<button class="btn btn-success btn-sm">Restore</button></form>';
            })
            ->addColumn('delete', function ($row) {
                $url = route('marketings.forceDeleted', $row->id);
                return '<form method="POST" action="' . $url . '">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button class="btn btn-danger btn-sm">Force Delete</button></form>';
            })
            ->rawColumns(['image', 'restore', 'delete'])
            ->make(true);
    }
}
