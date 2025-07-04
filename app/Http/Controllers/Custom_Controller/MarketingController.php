<?php

namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class MarketingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'hr' && Auth::user()->role !== 'marketing') {
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
            $marketing = Marketing::onlyTrashed()->get();
            return view('marketings.restored', compact('marketing'));

        }
        else
        {
            $marketing = Marketing::all();
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:marketings,email',
            'phone'      => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'image'      => 'nullable|image|max:2048',
        ]);

         if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('marketings', 'public');
        }

        Marketing::create($validated);

        return redirect()->route('marketings.index')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marketing $marketing)
    {
        return view('marketings.show', compact('marketing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marketing $marketing)
    {
        return view('marketings.edit', compact('marketing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marketing $marketing)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:marketings,email,' . $marketing->id,
            'phone'      => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'image'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($marketing->image) {
                Storage::disk('public')->delete($marketing->image);
            }

            $validated['image'] = $request->file('image')->store('marketings', 'public');
        }

        $marketing->update($validated);

        return redirect()->route('marketings.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $marketing = Marketing::findOrFail($id);
        $marketing->delete();

        return redirect()->route('marketings.index')->with('success', 'data deleted successfully.');
    }

    public function restore($id)
    {
        $marketing=Marketing::onlyTrashed()->find($id)->restore();
        return redirect()->route('marketings.index');

    }

    public function forceDeleted($id)
    {
        $marketing=Marketing::withTrashed()->find($id);
        $marketing->forceDelete();
        return redirect()->route('marketings.index');
    }
}
