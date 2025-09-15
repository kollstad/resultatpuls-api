<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HealthController extends Controller
{
    public function basic()
    {
        return response()->json([
            'status'   => 'ok',
            'app'      => config('app.name'),
            'env'      => config('app.env'),
            'time'     => now()->toISOString(),
            'version'  => \Illuminate\Foundation\Application::VERSION,
        ]);
    }

    public function full()
    {
        $checks = [
            'db'      => false,
            'cache'   => false,
            'storage' => false,
        ];

        // DB
        try {
            DB::select('select 1');
            $checks['db'] = true;
        } catch (\Throwable $e) {
            $checks['db'] = $e->getMessage();
        }

        // Cache
        try {
            Cache::put('healthcheck', 'ok', 5);
            $checks['cache'] = Cache::get('healthcheck') === 'ok' ? true : 'read/write failed';
        } catch (\Throwable $e) {
            $checks['cache'] = $e->getMessage();
        }

        // Storage
        try {
            $disk = Storage::disk('local');
            $disk->put('healthcheck.txt', 'ok');
            $ok = $disk->exists('healthcheck.txt');
            if ($ok) $disk->delete('healthcheck.txt');
            $checks['storage'] = $ok ? true : 'write failed';
        } catch (\Throwable $e) {
            $checks['storage'] = $e->getMessage();
        }

        $overall = collect($checks)->every(fn ($v) => $v === true) ? 'ok' : 'degraded';

        return response()->json([
            'status'   => $overall,
            'checks'   => $checks,
            'time'     => now()->toISOString(),
        ]);
    }
}
