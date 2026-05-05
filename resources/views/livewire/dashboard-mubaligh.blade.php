<div class="space-y-6">
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard Mubaligh</h2>
        <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Selamat datang ke panel tugasan Mubaligh.</p>
    </div>

    <!-- 4 Kad Statistik -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <!-- Card 1 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Mualaf</span>
                    <h4 class="text-2xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $jumlahMualaf }}</h4>
                </div>
            </div>
        </div>

        <!-- Card 2: Mualaf Perlu Diziarah -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-500 dark:bg-rose-500/10 dark:text-rose-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Mualaf Perlu Diziarah</span>
                    <h4 class="text-2xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $mualafPerluDiziarah }}</h4>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-500 dark:bg-amber-500/10 dark:text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tuntutan Belum Selesai</span>
                    <h4 class="text-2xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $tuntutanBelumSelesai }}</h4>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-500 dark:bg-indigo-500/10 dark:text-indigo-400">
                    <span class="text-lg font-bold">RM</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Tuntutan</span>
                    <h4 class="text-2xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ number_format($jumlahTuntutanRM, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Tindakan Pantas (Quick Actions) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Tindakan Pantas (Quick Actions)</h3>
        <div class="flex flex-wrap gap-3">
            <a href="/pusat-pengurusan" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white hover:bg-brand-600 transition">
                + Daftar Mualaf
            </a>
            <a href="/pusat-pengurusan" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50">
                + Lapor Kematian
            </a>
            <a href="/pusat-pengurusan" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50">
                + Cipta Tuntutan Baru
            </a>
            <a href="/ziarah" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50">
                + Rekod Ziarah
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Jadual Kes Kematian Saya -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Kes Kematian yang Dilaporkan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/[0.02]">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Arwah Mualaf</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status Kes</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tarikh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($kematians as $k)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-white font-medium">{{ $k->mualaf?->nama_penuh }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">{{ ucwords(str_replace('_', ' ', $k->status_kes)) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $k->tarikh_mati?->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tiada laporan kes kematian dijumpai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Jadual Tuntutan Saya -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Tuntutan Saya Terkini</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/[0.02]">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($tuntutans as $t)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ ucwords(str_replace('_', ' ', $t->jenis_tuntutan)) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-white font-medium">RM {{ number_format($t->jumlah_tuntutan, 2) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($t->status_tuntutan === 'pending')
                                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">Pending</span>
                                    @elseif ($t->status_tuntutan === 'lulus_kudd')
                                        <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">Lulus KUDD</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">Selesai MAIPk</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tiada laporan tuntutan dijumpai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Fokus Ziarah Segera -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Fokus Ziarah Segera (Kritikal & Amaran)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/[0.02]">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama Mualaf</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tarikh Ziarah Terakhir</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($mualafKritikal as $mk)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-white font-medium">
                                {{ $mk->nama_penuh }}
                                <div class="text-xs text-gray-400">IC: {{ $mk->no_ic }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $mk->tarikh_ziarah }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($mk->status === 'red')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-500/20 dark:text-red-400">
                                        <span class="h-2 w-2 rounded-full bg-red-600"></span>
                                        Belum Pernah Diziarahi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">
                                        <span class="h-2 w-2 rounded-full bg-amber-600"></span>
                                        Melebihi 6 Bulan
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="/ziarah" class="text-brand-500 hover:text-brand-600 font-medium">Ziarah</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tiada mualaf berstatus kritikal dijumpai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
