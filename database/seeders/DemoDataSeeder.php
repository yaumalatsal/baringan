<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Item;
use App\Models\ItemLog;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Demonstration data for the public instance.
 *
 *     php artisan db:seed --class=DemoDataSeeder
 *
 * The public instance exists to be looked at. Empty, every dashboard panel
 * reads zero, and a reader cannot tell a system that works from one that was
 * never finished. This fills it with a plausible four-floor hospital wing.
 *
 * Not for production. It refuses to run when items already exist, so it
 * cannot quietly double a real inventory; pass --force-demo to reset the demo
 * data instead.
 *
 * The numbers are chosen to make the dashboard say something. Equipment is
 * not evenly spread: intensive care holds more than an outpatient floor, a
 * minority of items are dirty or broken rather than a tidy half, and check
 * dates cluster in the recent past with a tail of items nobody has looked at
 * for months. A uniform distribution would look synthetic at a glance.
 */
class DemoDataSeeder extends Seeder
{
    /** Floors, and how many rooms each has. */
    private const FLOORS = [
        'Lantai 1 — Instalasi Gawat Darurat' => 8,
        'Lantai 2 — Rawat Inap' => 12,
        'Lantai 3 — Intensive Care' => 6,
        'Lantai 4 — Poliklinik' => 10,
    ];

    /** Equipment, with the brands actually seen in Indonesian hospitals. */
    private const EQUIPMENT = [
        ['Tempat Tidur Pasien', ['Paramount', 'Hillrom', 'Stryker']],
        ['Monitor Pasien', ['Mindray', 'Philips', 'GE Healthcare']],
        ['Infusion Pump', ['B. Braun', 'Terumo', 'Fresenius']],
        ['Syringe Pump', ['Terumo', 'Mindray']],
        ['Ventilator', ['Dräger', 'Hamilton', 'Mindray']],
        ['Tabung Oksigen', ['Samator', 'Aneka Gas']],
        ['Kursi Roda', ['Onemed', 'Sella']],
        ['Tiang Infus', ['Onemed', 'GEA']],
        ['Nebulizer', ['Omron', 'Yuwell']],
        ['Suction Pump', ['Yuwell', 'GEA']],
        ['Defibrillator', ['Mindray', 'Philips']],
        ['ECG Machine', ['Fukuda', 'Mindray']],
        ['Timbangan Digital', ['Onemed', 'Camry']],
        ['Lampu Tindakan', ['Dr Mach', 'GEA']],
        ['Troli Emergensi', ['Onemed', 'GEA']],
    ];

    public function run(): void
    {
        if (Item::count() > 0 && ! $this->confirmReset()) {
            $this->command?->warn('Items already exist — skipping. Use --force-demo to reset.');

            return;
        }

        // Deterministic: re-seeding produces the same wing, so a screenshot
        // taken today still matches the instance next month.
        mt_srand(20260918);

        DB::transaction(function () {
            $this->seedUsers();
            [$rooms, $floors] = $this->seedFloorsAndRooms();
            $items = $this->seedItems($rooms, $floors);
            $this->seedLogs($items);
        });

        $this->command?->info(sprintf(
            'Seeded %d floors, %d rooms, %d items, %d logs.',
            Floor::count(),
            Room::count(),
            Item::count(),
            ItemLog::count(),
        ));
    }

    private function confirmReset(): bool
    {
        if (! in_array('--force-demo', $_SERVER['argv'] ?? [], true)) {
            return false;
        }

        ItemLog::query()->delete();
        Item::query()->delete();
        Room::query()->delete();
        Floor::query()->delete();

        return true;
    }

    private function seedUsers(): void
    {
        // A read-only viewer account is what a visitor is given, so it must
        // exist before anyone is pointed at the login page.
        $accounts = [
            ['Demo Viewer', 'demo@baringan.test'],
            ['Petugas Inventaris', 'inventaris@baringan.test'],
            ['Kepala Ruangan', 'karu@baringan.test'],
            ['Teknisi Alat', 'teknisi@baringan.test'],
        ];

        foreach ($accounts as [$name, $email]) {
            User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => Hash::make('demo1234')],
            );
        }
    }

    /** @return array{0: array<int, Room>, 1: array<int, Floor>} */
    private function seedFloorsAndRooms(): array
    {
        $rooms = [];
        $floors = [];

        foreach (self::FLOORS as $floorName => $roomCount) {
            $floor = Floor::create(['name' => $floorName]);
            $floors[] = $floor;
            $prefix = (int) filter_var($floorName, FILTER_SANITIZE_NUMBER_INT);

            for ($i = 1; $i <= $roomCount; $i++) {
                // Roughly a third of rooms occupied. A ward that is either
                // empty or full tells the reader nothing about the system.
                $occupied = mt_rand(1, 100) <= 34;

                $rooms[] = Room::create([
                    'floor_id' => $floor->id,
                    'name' => sprintf('Kamar %d%02d', $prefix, $i),
                    'status' => $occupied,
                    'patient' => $occupied ? $this->patientName() : null,
                ]);
            }
        }

        return [$rooms, $floors];
    }

    /** @return array<int, Item> */
    private function seedItems(array $rooms, array $floors): array
    {
        $items = [];
        $serial = 1;

        foreach ($rooms as $room) {
            // Intensive care carries more equipment per room than a clinic.
            $isIcu = str_contains($room->floor->name ?? '', 'Intensive');
            $count = $isIcu ? mt_rand(5, 8) : mt_rand(2, 5);

            for ($i = 0; $i < $count; $i++) {
                [$name, $brands] = self::EQUIPMENT[mt_rand(0, count(self::EQUIPMENT) - 1)];

                $entry = Carbon::now()->subDays(mt_rand(120, 1460));
                // A tail of items nobody has checked in months is the thing an
                // inventory dashboard is supposed to surface.
                $checked = mt_rand(1, 100) <= 15
                    ? $entry->copy()->addDays(mt_rand(1, 60))
                    : Carbon::now()->subDays(mt_rand(0, 45));

                // No floor_id here: Item::$fillable lists it but the items
                // table has no such column, so writing it raises "no column
                // named floor_id". A room already knows its floor.
                $items[] = Item::create([
                    'room_id' => $room->id,
                    'name' => $name,
                    'merk' => $brands[mt_rand(0, count($brands) - 1)],
                    'code' => sprintf('BRG-%04d', $serial++),
                    'entry_date' => $entry->toDateString(),
                    'last_checked_date' => $checked->toDateString(),
                    'condition' => $this->condition(),
                    // Most equipment is clean; the minority that is not is the
                    // signal, so the split is deliberately lopsided.
                    'clean_status' => mt_rand(1, 100) <= 78,
                ]);
            }
        }

        return $items;
    }

    /**
     * Movement history.
     *
     * Only some items have been moved or re-checked, because a log with one
     * entry per item on the same day is obviously generated.
     */
    private function seedLogs(array $items): void
    {
        foreach ($items as $item) {
            if (mt_rand(1, 100) > 55) {
                continue;
            }

            foreach (range(1, mt_rand(1, 4)) as $n) {
                ItemLog::create([
                    'item_id' => $item->id,
                    'room_id' => $item->room_id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'merk' => $item->merk,
                    'entry_date' => $item->entry_date,
                    'last_checked_date' => Carbon::now()
                        ->subDays(mt_rand(1, 400))
                        ->toDateString(),
                    'condition' => $this->condition(),
                    'clean_status' => mt_rand(1, 100) <= 78,
                ]);
            }
        }
    }

    private function condition(): string
    {
        $roll = mt_rand(1, 100);

        return match (true) {
            $roll <= 82 => 'BAIK',
            $roll <= 95 => 'RUSAK',
            default => 'TIDAK TERSEDIA',
        };
    }

    private function patientName(): string
    {
        $first = ['Budi', 'Siti', 'Agus', 'Dewi', 'Rian', 'Putri', 'Eko', 'Rina', 'Joko', 'Ayu'];
        $last = ['Santoso', 'Wijaya', 'Pratama', 'Lestari', 'Nugroho', 'Handayani', 'Saputra'];

        return $first[mt_rand(0, count($first) - 1)] . ' ' . $last[mt_rand(0, count($last) - 1)];
    }
}
