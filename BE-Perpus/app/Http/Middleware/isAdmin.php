<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $role = Role::where('name', 'owner')->first();

        if($user->role_id === $role->id)
        {
            return $next($request);
        }

        return response()->json([
            'message' => 'Only owner that allowed to access this page'
        ], 401);
    }
}
