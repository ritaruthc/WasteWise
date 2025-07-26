<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\Log; 

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        Log::warning('Unauthorized access attempt', [
            'user_id' => auth()->id(),
            'url' => $request->url(),
            'admin_check' => auth()->check() ? auth()->user()->is_admin : null,
        ]);

        return redirect('/')->with('error', 'Akses tidak diizinkan.');
    }

}