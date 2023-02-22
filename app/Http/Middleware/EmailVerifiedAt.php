<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiedAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $emailverified = "";
        $userId = Auth::user()->getAuthIdentifier();
        $user = User::where('id','=', $userId)
            ->get();
        foreach ($user as $item) {
            $emailverified = $item['email_verified_at'];
        }

        return redirect($emailverified == null ? 'verificacion' : 'dashboard');

    }
}
