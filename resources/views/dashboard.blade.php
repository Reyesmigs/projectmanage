<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .table th, .table td {
            text-align: center; /* Center all text in the table */
            vertical-align: middle;
        }
        .projects-table {
            background-color: #007bff; /* Blue table header */
            color: white;
        }
        .tasks-table {
            background-color: #28a745; /* Green table header */
            color: white;
        }
        .card-header {
            font-weight: bold;
        }
            </style>
        </head>
        <nav class="navbar navbar-dark bg-black">
        <div class="container">
        <a href="dashboard" class="navbar-brand">Project Management</a>
    </div>
</nav>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-left mb-4">Welcome, <strong>{{ Auth::user()->name }}!</strong></h2>

        {{-- Projects Section --}}
        <div class="card my-4 shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="m-0">Your Projects</h3>
                <a href="{{ route('projects.create') }}" class="btn btn-light">+ Create Project</a>
            </div>
            <div class="card-body">
                @if ($projects->count() > 0)
                    <table class="table table-bordered border-black">
                        <thead class="projects-table">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->description }}</td>
                                <td><span class="badge bg-success">{{ $project->status }}</span></td>
                                <td>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-muted">No projects found.</p>
                @endif
            </div>
        </div>

        {{-- Tasks Section --}}
        <div class="card my-4 shadow">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h3 class="m-0">Your Tasks</h3>
                <a href="{{ route('tasks.create') }}" class="btn btn-light">+ Create Task</a>
            </div>
            <div class="card-body">
                @if (isset($tasks) && $tasks->count() > 0)
                <table class="table table-bordered border-black">
                    <thead class="project-table">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project->name ?? 'No Project' }}</td>
                            <td>
                                <span class="badge bg-{{ $task->status == 'Completed' ? 'success' : ($task->status == 'Active' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>                        
@else
    <p class="text-center text-muted">No tasks found.</p>
@endif
            </div>
        </div>

        {{-- Logout Button --}}
        <div class="text-left">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
