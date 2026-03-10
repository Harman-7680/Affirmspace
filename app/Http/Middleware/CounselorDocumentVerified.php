<?php
namespace App\Http\Middleware;

use Closure;

class CounselorDocumentVerified
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->role == 1) {

            if ($user->documents_status == 3) {

                // Allow profile page
                if ($request->routeIs('profile')) {
                    return $next($request);
                }

                // Block documents page
                if ($request->routeIs('counselor.documents')) {
                    return redirect()->route('profile');
                }

                return $next($request);
            }

            // 0 = Documents not uploaded
            if ($user->documents_status == 0) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'status'  => 'documents_required',
                        'message' => 'Please upload your verification documents first.',
                        'user'    => $user,
                    ], 403);
                }

                if (! $request->routeIs('counselor.documents')) {
                    return redirect()->route('counselor.documents');
                }
            }

            // 1 = Pending
            if ($user->documents_status == 1) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'status'  => 'documents_pending',
                        'message' => 'Your documents are under verification.',
                        'user'    => $user,
                    ], 403);
                }

                if (! $request->routeIs('counselor.documents')) {
                    return redirect()->route('counselor.documents')
                        ->with('message', 'Your documents are under verification.');
                }
            }

            // 2 = Rejected
            if ($user->documents_status == 2) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'status'  => 'documents_rejected',
                        'message' => 'Your documents were rejected. Please upload again.',
                        'user'    => $user,
                    ], 403);
                }

                if (! $request->routeIs('counselor.documents')) {
                    return redirect()->route('counselor.documents')
                        ->with('message', 'Your documents were rejected. Please upload again.');
                }
            }
        }

        return $next($request);
    }
}
