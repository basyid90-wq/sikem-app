<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Mualaf (Direktori Profil)
        </h2>
        <div class="flex items-center gap-3">
            <button wire:click="openImport()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                Import Excel
            </button>
            <button wire:click="openForm()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H5a1 1 0 110-2h3V6a1 1 0 011-1z" />
                </svg>
                Tambah Mualaf
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- BAHAGIAN ATAS: Dashboard-First Statistics -->
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Keseluruhan</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalKeseluruhan) }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Lost Contact</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalLostContact) }}</span>
            </div>
        </div>
    </div>

    <!-- BAHAGIAN TENGAH: Navigasi Tabs Dinamik -->
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

        <div class="relative flex-1 max-w-md">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau No. IC..." 
                class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-12 pr-4 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
        </div>
    </div>

    <!-- BAHAGIAN BAWAH: Listing Table -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-200 dark:bg-gray-800/50 dark:border-gray-700">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-12">No.</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama Mualaf</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">No. IC</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-center">T. Syahadah</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kariah</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-center">Khairat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($mualafs as $index => $mualaf)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/70">
                                {{ $mualafs->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $mualaf->nama_penuh }}</div>
                                @if($mualaf->no_kad_mualaf)
                                    <span class="inline-flex rounded bg-blue-50 px-1.5 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">Kad: {{ $mualaf->no_kad_mualaf }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $mualaf->no_ic }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                                {{ $mualaf->tarikh_syahadah ? $mualaf->tarikh_syahadah->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $mualaf->kariah ? $mualaf->kariah->nama_kariah : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($mualaf->status_khairat)
                                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                @else
                                    <span class="inline-flex h-2 w-2 rounded-full bg-gray-300 dark:bg-gray-700"></span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <button wire:click="toggleStatusAktif({{ $mualaf->id }})" 
                                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold transition-all cursor-pointer {{ $mualaf->is_aktif ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                    @if($mualaf->is_aktif)
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                        Aktif
                                    @else
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                        Lost Contact
                                    @endif
                                </button>
                            </td>
                            <td class="px-6 py-4 text-sm text-right flex items-center justify-end gap-3">
                                <button wire:click="openView({{ $mualaf->id }})" class="group flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all dark:bg-blue-900/20 dark:text-blue-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                                <button wire:click="openForm({{ $mualaf->id }})" class="group flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-500 hover:bg-brand-500 hover:text-white transition-all dark:bg-brand-900/20">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button onclick="confirm('Padam profil ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $mualaf->id }})" class="group flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all dark:bg-red-900/20">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="mb-2 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <p class="text-sm">Tiada rekod mualaf dijumpai dalam senarai {{ is_numeric($activeTab) ? 'Tahun '.$activeTab : $activeTab }}.</p>
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

    <!-- Modal Form -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-[999] flex justify-center bg-black/60 p-4 backdrop-blur-sm overflow-y-auto pt-24 pb-10">
            <div class="w-full max-w-4xl h-fit rounded-2xl bg-white shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-6 py-5">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        {{ $mualafId ? 'Kemaskini Profil Mualaf' : 'Tambah Mualaf Baru' }}
                    </h3>
                    <button wire:click="closeForm()" class="group -mr-2 rounded-xl p-2.5 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all dark:hover:bg-red-900/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- SEKSYEN 1: MAKLUMAT PERIBADI -->
                    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-5 dark:border-gray-800 dark:bg-gray-800/30">
                        <h4 class="mb-4 text-sm font-bold text-brand-600 dark:text-brand-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 pb-2">1. Maklumat Peribadi</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Asal</label>
                                <input type="text" wire:model="nama_asal" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('nama_asal') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-2 lg:col-span-1">
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Islam</label>
                                <input type="text" wire:model="nama_penuh" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('nama_penuh') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">No. IC</label>
                                <input type="text" wire:model="no_ic" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('no_ic') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Jantina</label>
                                <select wire:model="jantina" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    <option value="">-- Pilih Jantina --</option>
                                    <option value="Lelaki">Lelaki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('jantina') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Bangsa Asal</label>
                                <input type="text" wire:model="bangsa_asal" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('bangsa_asal') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Tarikh Lahir</label>
                                <div wire:ignore 
                                     x-data="{ 
                                        value: @entangle('tarikh_lahir'),
                                        init() {
                                            flatpickr($refs.input, {
                                                dateFormat: 'Y-m-d',
                                                altInput: true,
                                                altFormat: 'd/m/Y',
                                                onChange: (selectedDates, dateStr) => {
                                                    this.value = dateStr;
                                                }
                                            });
                                        }
                                     }">
                                    <input x-ref="input" x-bind:value="value" type="text" placeholder="Pilih Tarikh" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                </div>
                                @error('tarikh_lahir') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">No. Telefon</label>
                                <input type="text" wire:model="no_telefon" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('no_telefon') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Status Perkahwinan</label>
                                <select wire:model="status_perkahwinan" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    <option value="">-- Pilih --</option>
                                    <option value="Bujang">Bujang</option>
                                    <option value="Berkahwin">Berkahwin</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Janda">Janda</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                                @error('status_perkahwinan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Bil. Anak</label>
                                <input type="number" wire:model="bil_anak" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" min="0" />
                                @error('bil_anak') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SEKSYEN 2: MAKLUMAT PENGISLAMAN -->
                    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-5 dark:border-gray-800 dark:bg-gray-800/30">
                        <h4 class="mb-4 text-sm font-bold text-brand-600 dark:text-brand-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 pb-2">2. Maklumat Pengislaman</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Tarikh Syahadah</label>
                                <div wire:ignore 
                                     x-data="{ 
                                        value: @entangle('tarikh_syahadah'),
                                        init() {
                                            flatpickr($refs.input, {
                                                dateFormat: 'Y-m-d',
                                                altInput: true,
                                                altFormat: 'd/m/Y',
                                                onChange: (selectedDates, dateStr) => {
                                                    this.value = dateStr;
                                                }
                                            });
                                        }
                                     }">
                                    <input x-ref="input" x-bind:value="value" type="text" placeholder="Pilih Tarikh" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                </div>
                                @error('tarikh_syahadah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Tempat Syahadah (Lokasi Masuk Islam)</label>
                                <input type="text" wire:model="tempat_syahadah" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('tempat_syahadah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">No. Kad Mualaf</label>
                                <input type="text" wire:model="no_kad_mualaf" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('no_kad_mualaf') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Kariah</label>
                                <select wire:model="kariah_id" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    <option value="">-- Pilih Kariah --</option>
                                    @foreach($kariahs as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kariah }}</option>
                                    @endforeach
                                </select>
                                @error('kariah_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SEKSYEN 3: MAKLUMAT KEDIAMAN & PEKERJAAN -->
                    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-5 dark:border-gray-800 dark:bg-gray-800/30">
                        <h4 class="mb-4 text-sm font-bold text-brand-600 dark:text-brand-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 pb-2">3. Maklumat Kediaman & Pekerjaan</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Pekerjaan</label>
                                <input type="text" wire:model="pekerjaan" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                @error('pekerjaan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Alamat Terkini</label>
                                <textarea wire:model="alamat_terkini" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" rows="2"></textarea>
                                @error('alamat_terkini') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SEKSYEN 4: KEBAJIKAN & WARIS -->
                    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-5 dark:border-gray-800 dark:bg-gray-800/30">
                        <h4 class="mb-4 text-sm font-bold text-brand-600 dark:text-brand-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 pb-2">4. Kebajikan & Waris</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Status Kebajikan -->
                            <div class="space-y-4">
                                <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</h5>
                                <div class="flex flex-col gap-3">
                                    <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <input type="checkbox" wire:model="status_khairat" class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500" />
                                        <span class="text-sm font-medium text-gray-800 dark:text-white">Daftar sebagai Ahli Khairat?</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <input type="checkbox" wire:model="status_kematian" class="h-5 w-5 rounded border-gray-300 text-red-500 focus:ring-red-500" />
                                        <span class="text-sm font-medium text-gray-800 dark:text-white">Mualaf telah meninggal dunia?</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Maklumat Waris -->
                            <div class="space-y-4">
                                <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Waris Islam</h5>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input type="text" wire:model="waris_islam_nama" placeholder="Nama" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                    <div>
                                        <input type="text" wire:model="waris_islam_tel" placeholder="No Tel" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                </div>
                                <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mt-4">Waris Non-Muslim</h5>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input type="text" wire:model="waris_non_nama" placeholder="Nama" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                    <div>
                                        <input type="text" wire:model="waris_non_tel" placeholder="No Tel" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Upload Dokumen -->
                            <div class="sm:col-span-2 space-y-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Dokumen Sokongan</h5>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Sijil Masuk Islam</label>
                                        <input type="file" wire:model="sijil_islam" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                                        @error('sijil_islam') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Kad Mualaf</label>
                                        <input type="file" wire:model="kad_mualaf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                                        @error('kad_mualaf') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-5">
                        <button type="button" wire:click="closeForm()" class="px-5 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Excel Import Modal -->
    @if($isImportOpen)
        <div class="fixed inset-0 z-[999] flex justify-center bg-black/60 p-4 backdrop-blur-sm overflow-y-auto pt-24 pb-10">
            <div class="w-full max-w-lg h-fit rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-6 py-5">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        Import Data Mualaf dari Excel
                    </h3>
                    <button wire:click="closeImport()" class="group -mr-2 rounded-xl p-2.5 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all dark:hover:bg-red-900/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="importExcel" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Pilih Fail Excel (.xlsx, .xls, .csv)</label>
                        <input type="file" wire:model="excel_file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                        @error('excel_file') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-5">
                        <button type="button" wire:click="closeImport()" class="px-5 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition">Import Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    
    <!-- Mualaf Detail Modal (Profile Style) -->
    @if($isViewOpen && $viewingMualaf)
        <div class="fixed inset-0 z-[999] flex justify-center bg-black/60 p-4 backdrop-blur-sm overflow-y-auto pt-24 pb-10">
            <div class="w-full max-w-4xl h-fit rounded-2xl bg-white shadow-2xl dark:bg-gray-900 dark:border dark:border-gray-800">
                <!-- Modal Header -->
                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white/95 px-8 py-5 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/95">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Profil Terperinci Mualaf</h3>
                    <button wire:click="closeView()" class="group -mr-2 rounded-xl p-2.5 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all dark:hover:bg-red-900/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 sm:p-8 space-y-8">
                    <!-- Top Header Section (Profile Style) -->
                    <div class="relative rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-start">
                            <div class="relative h-32 w-32 shrink-0 overflow-hidden rounded-full border-4 border-white shadow-lg dark:border-gray-800">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($viewingMualaf->nama_penuh) }}&background=6366f1&color=fff&size=128" alt="Avatar" class="h-full w-full object-cover">
                            </div>
                            <div class="text-center sm:text-left">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $viewingMualaf->nama_penuh }}</h2>
                                <p class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $viewingMualaf->nama_asal ?: 'Tiada Nama Asal' }} • {{ $viewingMualaf->jantina }}
                                </p>
                                <div class="mt-4 flex flex-wrap justify-center gap-3 sm:justify-start">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        {{ $viewingMualaf->no_ic }}
                                    </span>
                                    @if($viewingMualaf->no_kad_mualaf)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            ID: {{ $viewingMualaf->no_kad_mualaf }}
                                        </span>
                                    @endif
                                    @if($viewingMualaf->status_khairat)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                            Ahli Khairat
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Left Column: Personal & Residential -->
                        <div class="space-y-8">
                            <!-- Maklumat Peribadi -->
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                                <h4 class="mb-5 flex items-center gap-2 text-base font-bold text-gray-800 dark:text-white">
                                    <span class="h-1.5 w-4 rounded-full bg-brand-500"></span>
                                    Maklumat Peribadi
                                </h4>
                                <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Bangsa Asal</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->bangsa_asal ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Tarikh Lahir</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->tarikh_lahir ? $viewingMualaf->tarikh_lahir->format('d/m/Y') : '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">No. Telefon</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->no_telefon ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Status Kahwin</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->status_perkahwinan ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Bilangan Anak</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->bil_anak }} Orang</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Pekerjaan</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->pekerjaan ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                                <h4 class="mb-5 flex items-center gap-2 text-base font-bold text-gray-800 dark:text-white">
                                    <span class="h-1.5 w-4 rounded-full bg-brand-500"></span>
                                    Maklumat Kediaman
                                </h4>
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Alamat Terkini</p>
                                    <p class="mt-2 text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                                        {{ $viewingMualaf->alamat_terkini ?: 'Tiada maklumat alamat.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Islamization & Waris -->
                        <div class="space-y-8">
                            <!-- Pengislaman -->
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                                <h4 class="mb-5 flex items-center gap-2 text-base font-bold text-gray-800 dark:text-white">
                                    <span class="h-1.5 w-4 rounded-full bg-brand-500"></span>
                                    Maklumat Pengislaman
                                </h4>
                                <div class="space-y-5">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Tarikh Syahadah</p>
                                            <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->tarikh_syahadah ? $viewingMualaf->tarikh_syahadah->format('d/m/Y') : '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Kariah</p>
                                            <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->kariah ? $viewingMualaf->kariah->nama_kariah : '-' }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Tempat Syahadah</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $viewingMualaf->tempat_syahadah ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Waris -->
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                                <h4 class="mb-5 flex items-center gap-2 text-base font-bold text-gray-800 dark:text-white">
                                    <span class="h-1.5 w-4 rounded-full bg-brand-500"></span>
                                    Maklumat Waris
                                </h4>
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50">
                                        <p class="text-[10px] font-bold uppercase text-gray-500">Waris Islam</p>
                                        <p class="mt-2 text-sm font-bold text-gray-900 dark:text-white">{{ $viewingMualaf->waris_islam_nama ?: '-' }}</p>
                                        <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">{{ $viewingMualaf->waris_islam_tel ?: 'Tiada No. Tel' }}</p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50">
                                        <p class="text-[10px] font-bold uppercase text-gray-500">Waris Non-Muslim</p>
                                        <p class="mt-2 text-sm font-bold text-gray-900 dark:text-white">{{ $viewingMualaf->waris_non_nama ?: '-' }}</p>
                                        <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">{{ $viewingMualaf->waris_non_tel ?: 'Tiada No. Tel' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 dark:border-gray-800 dark:bg-gray-900/50">
                    <div class="flex justify-end gap-3">
                        <button wire:click="closeView()" class="rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Tutup</button>
                        <button wire:click="openForm({{ $viewingMualaf->id }}); closeView();" class="rounded-lg bg-brand-500 px-5 py-2 text-sm font-semibold text-white hover:bg-brand-600">Edit Profil</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
