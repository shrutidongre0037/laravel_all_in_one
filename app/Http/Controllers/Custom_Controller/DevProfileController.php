<?php

namespace App\Http\Controllers\Custom_Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Development;
use App\Models\Profile;
use Illuminate\Support\Str;

class DevProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $development = Development::findOrFail($request->development_id);
        return view('profiles.form', compact('development'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'development_id' => 'required|exists:developments,id',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
        ]);

        $profile = Profile::create([
            'id' => Str::uuid(),
            'linkedin' => $request->linkedin,
            'github' => $request->github,
        ]);

        \App\Models\DevelopmentProfile::updateOrCreate(
            ['development_id' => $request->development_id],
            [
                'id' => Str::uuid(),
                'profile_id' => $profile->id,
            ]
        );
        return redirect()->route('developments.show', $request->development_id)->with('success', 'Profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        $developmentProfile = \App\Models\DevelopmentProfile::where('profile_id', $id)->firstOrFail();
        $development = $developmentProfile->development;
        $profile = $developmentProfile->profile;
        return view('profiles.form', compact('profile', 'development'));
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $request->validate([
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
        ]);

        $profile->update(
            $request->only(['linkedin', 'github'])
        );

        $developmentId = \App\Models\DevelopmentProfile::where('profile_id', $profile->id)->value('development_id');
        return redirect()->route('developments.show', $developmentId)->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
