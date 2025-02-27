<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch only the projects and tasks belonging to the logged-in user
        $projects = Project::where('user_id', Auth::id())->get();
        $tasks = Task::where('user_id', Auth::id())->get();

        // Pass both variables to the view
        return view('dashboard', compact('projects', 'tasks'));
    }
}
