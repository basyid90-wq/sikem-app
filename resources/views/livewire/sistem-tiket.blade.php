<div class="max-w-7xl mx-auto space-y-6">
    <!-- Top Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Sistem Tiket & Laporan Isu</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Urus dan pantau laporan isu atau masalah sistem.
            </p>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="/" class="hover:text-brand-500">Home</a>
            <span>&gt;</span>
            <span class="text-gray-800 dark:text-white font-medium">Tiket & Isu</span>
        </div>
    </div>

    @if (session()->has('ticket_message'))
        <div class="mb-4 flex items-center gap-4 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:border-emerald-800/40 dark:text-emerald-400">
            <svg class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-medium">{{ session('ticket_message') }}</span>
        </div>
    @endif

    <!-- 3 Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Tickets Card -->
        <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500 dark:bg-indigo-500/10 dark:text-indigo-400 flex-shrink-0">
                <!-- Ticket SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($totalTickets) }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah tiket</p>
            </div>
        </div>

        <!-- Pending Tickets Card -->
        <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-500 dark:bg-amber-500/10 dark:text-amber-400 flex-shrink-0">
                <!-- Hourglass SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"></path><path d="M5 2h14"></path><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"></path><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"></path></svg>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($pendingTickets) }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tiket pending</p>
            </div>
        </div>

        <!-- Solved Tickets Card -->
        <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-500 dark:bg-emerald-500/10 dark:text-emerald-400 flex-shrink-0">
                <!-- Check Circle SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($solvedTickets) }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tiket selesai</p>
            </div>
        </div>
    </div>

    <!-- Ticket Management Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Tiket Sokongan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai laporan isu terkini</p>
            </div>

            <!-- Tabs + Search + Action Button -->
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <!-- Tabs Filters -->
                <div class="inline-flex rounded-xl bg-gray-100 p-1 dark:bg-gray-700">
                    <button wire:click="setFilter('all')" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors {{ $filterStatus === 'all' ? 'bg-white text-gray-900 shadow-xs dark:bg-gray-600 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        All
                    </button>
                    <button wire:click="setFilter('pending')" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors {{ $filterStatus === 'pending' ? 'bg-white text-gray-900 shadow-xs dark:bg-gray-600 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Pending
                    </button>
                    <button wire:click="setFilter('solved')" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors {{ $filterStatus === 'solved' ? 'bg-white text-gray-900 shadow-xs dark:bg-gray-600 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Solved
                    </button>
                </div>

                <!-- Search Input -->
                <div class="relative flex-grow md:flex-grow-0">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari tajuk..." class="w-full md:w-64 rounded-xl border border-gray-200 bg-transparent py-2 pl-10 pr-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:text-white" />
                </div>

                <!-- Action Button for Normal User -->
                @if(!auth()->user()->hasRole('super_admin'))
                    <button wire:click="openForm" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600 transition shadow-sm">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Lapor Isu
                    </button>
                @endif
            </div>
        </div>

        <!-- Tickets Listing Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/40 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Requested By</th>
                        <th class="px-6 py-4">Subject</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tarikh</th>
                        @role('super_admin')
                            <th class="px-6 py-4">Kemas kini Status</th>
                        @endrole
                        <th class="px-6 py-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse ($tickets as $index => $t)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors">
                            <td class="px-6 py-4 text-gray-500">#{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $t->user?->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $t->user?->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col max-w-md">
                                    <button wire:click="selectTicket({{ $t->id }})" class="font-semibold text-left text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 transition">
                                        {{ $t->tajuk }}
                                    </button>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2" title="{{ $t->deskripsi }}">{{ $t->deskripsi }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $t->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($t->status === 'baru')
                                    <span class="inline-flex rounded-lg bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                        Baru
                                    </span>
                                @elseif ($t->status === 'dalam_tindakan')
                                    <span class="inline-flex rounded-lg bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                                        Dalam Tindakan
                                    </span>
                                @else
                                    <span class="inline-flex rounded-lg bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $t->created_at->format('d/m/Y') }}
                            </td>
                            @role('super_admin')
                                <td class="px-6 py-4">
                                    <select wire:change="updateTicketStatus({{ $t->id }}, $event.target.value)" class="rounded-xl border border-gray-200 bg-white dark:bg-gray-700 px-3 py-1.5 text-xs font-medium outline-none focus:border-brand-500 dark:border-gray-600 dark:text-white transition">
                                        <option value="baru" {{ $t->status === 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="dalam_tindakan" {{ $t->status === 'dalam_tindakan' ? 'selected' : '' }}>Dalam Tindakan</option>
                                        <option value="selesai" {{ $t->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </td>
                            @endrole
                            <td class="px-6 py-4 text-center">
                                <button wire:click="selectTicket({{ $t->id }})" class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 px-3 py-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 transition shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"></path></svg>
                                    Balas / Lihat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                Tiada sebarang laporan isu dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Create Ticket Popup) -->
    @if ($isFormOpen)
        <div class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto" x-cloak>
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeForm"></div>

            <div class="relative w-full max-w-xl rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-800 dark:border dark:border-gray-700 animate-fade-in-up">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Lapor Isu Baru</h3>
                    <button wire:click="closeForm" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="simpanTiket" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-gray-800 dark:text-white/90">Tajuk Isu</label>
                        <input type="text" wire:model="tajuk" placeholder="Contoh: Ralat ketika simpan rekod" class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" required />
                        @error('tajuk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-gray-800 dark:text-white/90">Kategori</label>
                        <select wire:model="kategori" class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                            <option value="Isu Paparan">Isu Paparan</option>
                            <option value="Isu Pengisian Data">Isu Pengisian Data</option>
                            <option value="Ralat Sistem">Ralat Sistem</option>
                            <option value="Cadangan Penambahbaikan">Cadangan Penambahbaikan</option>
                        </select>
                        @error('kategori') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-gray-800 dark:text-white/90">Deskripsi / Catatan Isu</label>
                        <textarea wire:model="deskripsi" rows="4" placeholder="Sila berikan maklumat lengkap tentang isu tersebut..." class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" required></textarea>
                        @error('deskripsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-gray-800 dark:text-white/90">Gambar/Bukti Isu (Jika ada)</label>
                        <input type="file" wire:model="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                        @error('gambar') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 pt-4 mt-4">
                        <button type="button" wire:click="closeForm" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800/40">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-500 text-sm font-semibold text-white hover:bg-brand-600 transition shadow-sm">
                            Hantar Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
