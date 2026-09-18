<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Gate for /api/monitor/*.
 *
 * These endpoints report how many items, rooms and users the install holds.
 * That is not personal data, but it describes the inside of a hospital's
 * inventory and was previously readable by anyone who found the URL.
 *
 * Accepts `Authorization: Bearer <token>` or `X-Monitor-Token`, so a generic
 * HTTP client works either way. Compared with hash_equals(): a monitor polls
 * this every few seconds forever, which is exactly the shape of traffic that
 * makes a timing side-channel practical to exploit.
 */
class VerifyMonitorToken
{
    public function handle(Request $request, Closure $next)
    {
        $expected = (string) config('monitor.token');

        if ($expected === '') {
            return response()->json([
                'error' => 'monitoring_disabled',
                'message' => 'No MONITOR_API_TOKEN is set on this install.',
            ], 503);
        }

        $given = (string) ($request->bearerToken() ?: $request->header('X-Monitor-Token', ''));

        if ($given === '' || ! hash_equals($expected, $given)) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Missing or invalid monitor token.',
            ], 401);
        }

        return $next($request);
    }
}
