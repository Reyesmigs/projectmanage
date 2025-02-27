<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Show all tasks for the logged-in user
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('tasks.index', compact('tasks'));
    }

    // Show the form to create a new task
    public function create()
{
    $projects = \App\Models\Project::where('user_id', Auth::id())->get();
    return view('tasks.create', compact('projects'));
}


    // Store a new task in the database
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',  // Make sure title is required
        'project_id' => 'required|exists:projects,id',
        'status' => 'required|string|in:Pending,Active,Completed',
        'due_date' => 'required|date',
    ]);

    // Create a Task
    Task::create([
        'title' => $request->title,  // Make sure title is being saved
        'project_id' => $request->project_id,
        'status' => $request->status,
        'due_date' => $request->due_date,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Task created successfully!');
}

    // Show the form to edit an existing task
    public function edit($id)
    {
        // Get the task and ensure it belongs to the logged-in user
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $projects = Project::where('user_id', Auth::id())->get();

        return view('tasks.edit', compact('task', 'projects'));
    }

    // Update an existing task in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:Pending,Active,Completed',
            'project_id' => 'required|exists:projects,id',
            'due_date' => 'nullable|date',
        ]);

        // Find the task and ensure it belongs to the logged-in user
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $task->update([
            'title' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'project_id' => $request->project_id,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }

    // Delete a task
    public function destroy($id)
    {
        // Find the task and ensure it belongs to the logged-in user
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }
}
