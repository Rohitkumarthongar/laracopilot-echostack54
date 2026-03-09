<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $teams = Team::orderBy('name')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        Team::create($validated);
        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $team = Team::findOrFail($id);
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $team = Team::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $team->update($validated);
        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Team removed successfully!');
    }
}
