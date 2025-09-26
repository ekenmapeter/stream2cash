<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActionLog;

class LogFormSubmission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log only authenticated, state-changing requests
        if (!Auth::check()) {
            return $response;
        }

        if (!in_array(strtoupper($request->getMethod()), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $response;
        }

        // Build action identifier
        $routeName = $request->route()?->getName();
        $action = $routeName ?: strtolower($request->method()) . ':' . trim($request->path(), '/');

        // Determine target user id if route model binding provides it; fallback to actor
        $routeParams = $request->route()?->parameters() ?? [];
        $targetUserId = Auth::id();
        foreach ($routeParams as $param) {
            if ($param instanceof \App\Models\User) {
                $targetUserId = $param->id;
                break;
            }
        }

        // Sanitize input to exclude sensitive fields
        $input = collect($request->all())
            ->except(['password', 'password_confirmation', '_token', '_method', 'current_password'])
            ->toArray();

        // Short description
        $description = sprintf(
            'Form submission on %s (%s)',
            $routeName ?: $request->path(),
            strtoupper($request->method())
        );

        // Deduplicate bursts: same admin + action + hash(payload) within 15s
        try {
            $fingerprint = sha1(json_encode([
                'admin' => Auth::id(),
                'target' => $targetUserId,
                'action' => $action,
                'input' => $input,
            ], JSON_UNESCAPED_UNICODE));

            $cacheKey = 'log_form_submission:' . $fingerprint;
            if (!\Cache::add($cacheKey, 1, now()->addSeconds(15))) {
                return $response; // recently logged, skip
            }

            // Defer write to queue
            \App\Jobs\LogFormSubmissionJob::dispatch(
                adminId: Auth::id(),
                targetUserId: $targetUserId,
                action: $action,
                description: $description,
                newData: $input ?: null,
                ipAddress: $request->ip(),
                userAgent: $request->userAgent()
            )->onQueue('low');
        } catch (\Throwable $e) {
            \Log::warning('LogFormSubmission enqueue failed: ' . $e->getMessage());
        }

        return $response;
    }
}


