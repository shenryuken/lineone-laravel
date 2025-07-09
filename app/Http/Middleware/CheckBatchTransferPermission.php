<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBatchTransferPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Check if user has permission for batch transfers
        $allowedRoles = ['admin', 'fund_manager', 'merchant'];
        
        if (!$user || !in_array($user->role, $allowedRoles)) {
            abort(403, 'You do not have permission to access batch transfers');
        }
        
        return $next($request);
    }
}
