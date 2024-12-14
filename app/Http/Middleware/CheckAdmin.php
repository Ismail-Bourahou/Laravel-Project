<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Admin::where('admin_code', session('user_id'))->first();

        // Vérifie si l'utilisateur est un enseignant
        if ($admin) {
            return $next($request);
        }

        // Redirection de l'utilisateur vers une page d'erreur ou une autre page appropriée
        return redirect()->route('error');
    }
}
