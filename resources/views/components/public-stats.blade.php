{{--
    Aggregate figures under the sign-in card.

    Deliberately quiet: this sits below the login form and must not compete
    with it. Muted text, no colour, no borders around each figure — it is
    context for someone deciding whether to look further, not a dashboard.

    Renders nothing at all on an empty install. A row of zeros says "broken";
    absence says nothing, which is more honest.
--}}
@if ($available)
    <div class="mt-8 w-full sm:max-w-md mx-auto px-6 sm:px-0">
        <p class="text-xs uppercase tracking-wider text-gray-400 text-center">
            Currently tracked
        </p>

        <dl class="mt-3 grid grid-cols-3 gap-4 text-center">
            <div>
                <dd class="text-2xl font-semibold text-gray-700">
                    {{ number_format($stats['items']) }}
                </dd>
                <dt class="text-xs text-gray-500">Peralatan</dt>
            </div>
            <div>
                <dd class="text-2xl font-semibold text-gray-700">
                    {{ number_format($stats['rooms']) }}
                </dd>
                <dt class="text-xs text-gray-500">Kamar</dt>
            </div>
            <div>
                <dd class="text-2xl font-semibold text-gray-700">
                    {{ number_format($stats['floors']) }}
                </dd>
                <dt class="text-xs text-gray-500">Lantai</dt>
            </div>
        </dl>

        <p class="mt-4 text-xs text-gray-500 text-center leading-relaxed">
            {{ $cleanPercent() }}% peralatan dalam status bersih ·
            {{ number_format($stats['rooms_occupied']) }} dari
            {{ number_format($stats['rooms']) }} kamar terisi ·
            {{ number_format($stats['logs']) }} riwayat perpindahan
        </p>

        <p class="mt-3 text-[11px] text-gray-400 text-center">
            Angka keseluruhan saja. Tidak ada data pasien atau petugas di halaman ini.
        </p>
    </div>
@endif
