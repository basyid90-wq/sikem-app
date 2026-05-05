<div class="space-y-6">
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Developer & Admin Dashboard</h2>
        <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Selamat datang ke panel kawalan khas Super Admin.</p>
    </div>

    @if (session()->has('message'))
        <div class="flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- System Info Widgets -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <!-- PHP Version Card -->
        <div class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Versi PHP</span>
                    <h4 class="text-xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $phpVersion }}</h4>
                </div>
            </div>
        </div>

        <!-- Laravel Version Card -->
        <div class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Versi Laravel</span>
                    <h4 class="text-xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $laravelVersion }}</h4>
                </div>
            </div>
        </div>

        <!-- Memory Status Card -->
        <div class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Memori Digunakan</span>
                    <h4 class="text-xl font-bold text-gray-800 mt-0.5 dark:text-white">{{ $memoryUsage }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Butang Tindakan Pantas (Quick Actions)</h3>
        <div class="flex flex-wrap gap-3">
            <!-- Butang Clear Cache -->
            <button wire:click="clearCache()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white hover:bg-brand-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                Clear Cache
            </button>

            <!-- Butang Optimize System -->
            <button wire:click="optimizeSystem()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg>
                Optimize Cache
            </button>

            <!-- Butang Log Viewer -->
            <a href="/log-viewer" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Log Viewer (Error Logs)
            </a>
        </div>
    </div>

    <!-- Senarai Tiket Semasa (Super Admin View) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Senarai Tiket Isu Semasa (Baru & Dalam Tindakan)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/[0.02]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tajuk Isu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Kemas kini Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tarikh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($currentTickets as $t)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white">
                                <span class="font-medium block">{{ $t->user?->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $t->user?->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white font-medium">{{ $t->tajuk }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $t->kategori }}</td>
                            <td class="px-6 py-4 text-sm">
                                <select wire:change="updateTicketStatus({{ $t->id }}, $event.target.value)" class="rounded-lg border border-gray-300 bg-transparent px-2.5 py-1 text-xs outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                                    <option value="baru" {{ $t->status === 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="dalam_tindakan" {{ $t->status === 'dalam_tindakan' ? 'selected' : '' }}>Dalam Tindakan</option>
                                    <option value="selesai" {{ $t->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $t->created_at->format('d/m/Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tiada laporan isu aktif buat masa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
