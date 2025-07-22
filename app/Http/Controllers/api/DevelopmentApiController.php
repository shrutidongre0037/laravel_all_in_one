<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Development;
use App\Http\Requests\StoreDevelopmentRequest;
use App\Events\DevelopmentCreated;

class DevelopmentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developments = Development::with(['department', 'projects'])->get();

        return response()->json($developments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDevelopmentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'developments');
        }

        $development = Development::create($data);

        if ($request->has('project_ids')) {
            $development->projects()->sync($request->project_ids);
        }

        event(new DevelopmentCreated($development));

        return response()->json(['message' => 'Created successfully', 'data' => $development]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
