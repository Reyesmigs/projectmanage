<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Show all projects for the logged-in user
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return view('projects.index', compact('projects'));
    }

    // Show create project form
    public function create()
    {
        return view('projects.create');
    }

    // Store a new project in the database
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required|string|in:Active,Pending,Inactive',
        ]);

        // Create a new project
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => Auth::id() // Assign to logged-in user
        ]);

        return redirect()->route('dashboard')->with('success', 'Project created successfully!');
    }

    // Show the edit form for a specific project
    public function edit($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    // Update project in the database
    public function update(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required|string|in:Active,Pending,Inactive',
        ]);

        // Find the project and ensure it belongs to the logged-in user
        $project = Project::where('user_id', Auth::id())->findOrFail($id);

        // Update project details
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Project updated successfully!');
    }

    // Delete a project
    public function destroy($id)
    {
        // Find the project and ensure it belongs to the logged-in user
        $project = Project::where('user_id', Auth::id())->findOrFail($id);

        // Delete the project
        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully!');
    }
}
