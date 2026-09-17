<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    /** /api/health — overall liveness probe */
    public function health()
    {
        // Verify the SQLite database is reachable
        $dbOk = true;
        $dbDetail = 'sqlite';
        try {
            DB::connection()->getPdo();
            $up = DB::select('SELECT strftime(\'%s\', \'now\') as t')[0]->t;
            $start = $_SERVER['REQUEST_TIME'];
            $uptime = is_numeric($start) ? (time() - (int) $start) : 0;
        } catch (\Throwable $e) {
            $dbOk = false;
            $dbDetail = 'unreachable: ' . $e->getMessage();
            $uptime = 0;
        }

        return response()->json([
            'status' => $dbOk ? 'ok' : 'down',
            'version' => '1.0.0',
            'uptime_seconds' => $uptime,
        ]);
    }

    /** /api/monitor/services — per-component status */
    public function services()
    {
        $services = [];

        // Database
        $dbStart = microtime(true);
        try {
            DB::connection()->getPdo();
            $dbLatency = (int) round((microtime(true) - $dbStart) * 1000);
            $services[] = [
                'name' => 'database',
                'status' => 'ok',
                'detail' => 'sqlite',
                'latency_ms' => $dbLatency,
            ];
        } catch (\Throwable $e) {
            $dbLatency = (int) round((microtime(true) - $dbStart) * 1000);
            $services[] = [
                'name' => 'database',
                'status' => 'down',
                'detail' => $e->getMessage(),
                'latency_ms' => $dbLatency,
            ];
        }

        return response()->json(['services' => $services]);
    }

    /** /api/monitor/metrics — business data counts and gauges */
    public function metrics()
    {
        $counts = [
            'items' => DB::table('items')->count(),
            'floors' => DB::table('floors')->count(),
            'rooms' => DB::table('rooms')->count(),
            'users' => DB::table('users')->count(),
            'item_logs' => DB::table('item_logs')->count(),
        ];

        $by_status = DB::table('items')
            ->selectRaw('clean_status, count(*) as count')
            ->groupBy('clean_status')
            ->pluck('count', 'clean_status')
            ->toArray();

        return response()->json([
            'counts' => $counts,
            'items_by_clean_status' => $by_status ?: ['unknown' => 0],
            'uptime_seconds' => time() - (int) $_SERVER['REQUEST_TIME'],
        ]);
    }
}
