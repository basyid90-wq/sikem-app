<div class="space-y-6">
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard Guru APIM</h2>
        <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Selamat datang ke panel pengajaran Guru APIM.</p>
    </div>

    <!-- 2 Kad Statistik -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <!-- Card 1 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Kelas Saya Bulan Ini</span>
                    <h4 class="text-2xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $jumlahKelas }} Kelas</h4>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <span class="text-lg font-bold">RM</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Elaun Terkumpul Bulan Ini</span>
                    <h4 class="text-2xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ number_format($jumlahElaun, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadual Kelas Seterusnya & Kehadiran -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Jadual Kelas & Kehadiran</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/[0.02]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Mod Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Masa Mula</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($upcomingClasses as $c)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white font-medium">{{ $c->tajuk_kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ ucfirst($c->mod_kelas) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $c->masa_mula?->format('d/m/Y h:i A') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                <a href="/pusat-pengurusan" class="text-brand-500 hover:text-brand-600 font-medium">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tiada sebarang kelas dijumpai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
