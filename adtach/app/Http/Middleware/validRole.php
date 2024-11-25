<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class validRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user')) {
            $user = session('user');  // Get user from session
            
            // Check if the user role is not 'user'
            if ($user->role !== 'user') {
                return $next($request);  // Continue the request if the user role is not 'user'
            } else {
                return redirect()->route('viewHome');  // Redirect to 'viewHome' if the role is 'user'
            }
        } else {
            // If the user is not logged in (session does not exist), redirect to login
            return redirect()->route('login');
        }
    }
}
