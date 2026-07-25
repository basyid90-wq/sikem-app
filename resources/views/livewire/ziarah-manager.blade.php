<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Ziarah & Silaturahim
        </h2>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- BAHAGIAN ATAS: Navigasi Tabs Dinamik -->
    <div class="mb-6 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap border-b border-gray-200 dark:border-gray-800">
            @foreach($this->dynamicTabs as $year)
                <button wire:click="$set('activeTab', '{{ $year }}')" 
                    class="relative px-6 py-3 text-sm font-semibold transition-all {{ $activeTab == $year ? 'text-brand-500 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-brand-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                    Tahun {{ $year }}
                </button>
            @endforeach

            <button wire:click="$set('activeTab', 'semua')" 
                class="relative px-6 py-3 text-sm font-semibold transition-all {{ $activeTab === 'semua' ? 'text-brand-500 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-brand-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                Semua Data
            </button>
        </div>

        <!-- Search Bar -->
        <div class="relative flex-1 max-w-md">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau IC..." class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-12 pr-4 text-sm outline-none focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
        </div>
    </div>

    <!-- Jadual Senarai Mualaf & Status Ziarah -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden shadow-sm">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-200 dark:bg-white/[0.01] dark:border-gray-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Nama Mualaf</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Alamat / Kawasan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">No. Telefon</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Ziarah Terakhir</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($mualafs as $m)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $m->nama_penuh }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">IC: {{ $m->no_ic }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $m->alamat_terkini ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $m->no_telefon ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 font-medium">
                                {{ $m->ziarahLogs->first()?->tarikh_ziarah?->format('d/m/Y') ?? 'Tiada Rekod' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="openLogZiarah({{ $m->id }})" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-xs font-bold text-white hover:bg-brand-600 transition shadow-sm shadow-brand-500/10">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    Log Ziarah
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-10 w-10 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                    Tiada rekod mualaf dijumpai bagi kategori ini.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $mualafs->links() }}
        </div>
    </div>

    <!-- Modal Log Sejarah & Tambah Ziarah -->
    @if($isModalOpen && $selectedMualaf)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Log Ziarah: {{ $selectedMualaf->nama_penuh }}
                    </h3>
                    <button wire:click="closeLogZiarah()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Borang Tambah Baru -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">Tambah Log Ziarah Baru</h4>
                        <form wire:submit.prevent="simpanLog" class="space-y-3">
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-800 dark:text-white/90">Tarikh Ziarah</label>
                                <input type="date" wire:model="tarikh_ziarah" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                                @error('tarikh_ziarah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-800 dark:text-white/90">Tujuan Ziarah</label>
                                <input type="text" wire:model="tujuan" placeholder="Cth: Kebajikan, bimbingan, santunan..." class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                                @error('tujuan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-800 dark:text-white/90">Nota Hasil Ziarah</label>
                                <textarea wire:model="nota_hasil_ziarah" rows="3" placeholder="Nota pemerhatian/tindakan..." class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"></textarea>
                                @error('nota_hasil_ziarah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-xs font-medium text-white hover:bg-brand-600 transition">Simpan Log Ziarah</button>
                            </div>
                        </form>
                    </div>

                    <!-- Sejarah Log Ziarah -->
                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">Sejarah Log Ziarah</h4>
                        <div class="space-y-3">
                            @forelse($history as $h)
                                <div class="rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50/50 p-3 dark:bg-white/[0.01]">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-bold text-brand-600 dark:text-brand-400">{{ $h->tarikh_ziarah->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Oleh: {{ $h->user?->name }}</span>
                                    </div>
                                    <div class="text-xs font-semibold text-gray-800 dark:text-white mt-1">Tujuan: {{ $h->tujuan }}</div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">{{ $h->nota_hasil_ziarah ?: '-' }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400 text-center py-4">Tiada sejarah log ziarah sebelum ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
