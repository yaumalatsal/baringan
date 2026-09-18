<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Illuminate\View\View;
use Throwable;

/**
 * Aggregate figures for the public landing page.
 *
 * Someone arriving at the login screen cannot see the system, so they cannot
 * tell whether it holds anything. These counts answer that without exposing a
 * single record: how much equipment is tracked, across how many rooms and
 * floors, and how much of it is currently clean.
 *
 * Only totals leave this class. No item name, no room name, no patient, no
 * user — nothing that identifies a person or a specific asset.
 *
 * Cached for five minutes. The login page is the most-hit route on the site
 * and these are five unindexed COUNT(*) queries; recomputing them per request
 * would make the cheapest page the most expensive one.
 */
class PublicStats extends Component
{
    private const CACHE_KEY = 'public-stats';
    private const CACHE_SECONDS = 300;

    public array $stats = [];
    public bool $available = false;

    public function __construct()
    {
        try {
            $this->stats = cache()->remember(
                self::CACHE_KEY,
                self::CACHE_SECONDS,
                fn () => $this->gather(),
            );
            // An empty install shows nothing rather than a row of zeros, which
            // reads as broken rather than new.
            $this->available = ($this->stats['items'] ?? 0) > 0;
        } catch (Throwable) {
            // The landing page must render even when the database does not
            // answer. A missing strip is better than a 500 on the front door.
            $this->available = false;
        }
    }

    private function gather(): array
    {
        $items = (int) DB::table('items')->count();

        return [
            'items' => $items,
            'rooms' => (int) DB::table('rooms')->count(),
            'floors' => (int) DB::table('floors')->count(),
            'logs' => (int) DB::table('item_logs')->count(),
            // clean_status is a boolean column; 1 is clean.
            'clean' => (int) DB::table('items')->where('clean_status', 1)->count(),
            'rooms_occupied' => (int) DB::table('rooms')->where('status', 1)->count(),
        ];
    }

    /** Share of equipment currently marked clean, as a whole number. */
    public function cleanPercent(): int
    {
        $items = $this->stats['items'] ?? 0;

        return $items > 0
            ? (int) round(($this->stats['clean'] / $items) * 100)
            : 0;
    }

    public function render(): View
    {
        return view('components.public-stats');
    }
}
