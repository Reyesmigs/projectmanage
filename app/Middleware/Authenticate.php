<?

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate {
    
public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect('/login')->error('error', 'You must be logged in to access this page.'); // Redirect if user is not logged in
    }

    return $next($request);
    }
}