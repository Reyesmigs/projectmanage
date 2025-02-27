<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Project Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="text-center">
        <h1 class="text-black">Welcome to Project Manager</h1>
        <h5 class="text-dark">Manage your projects and tasks efficiently.</h5>
        
        @if(Auth::check())
            <a href="{{ route('dashboard') }}" class="btn btn-success">Go to Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-success">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        @endif
    </div>
</body>
</html>
