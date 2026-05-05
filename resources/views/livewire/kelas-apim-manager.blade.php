<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Kelas (Modul Pendidikan)
        </h2>
        <button wire:click="openForm()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H5a1 1 0 110-2h3V6a1 1 0 011-1z" />
            </svg>
            Tambah Kelas Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari tajuk kelas..." class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-12 pr-4 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
            </div>
        </div>
    </div>

    <!-- Listing Section -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tajuk Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Guru / Pengajar</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Masa Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Mod Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($kelases as $kelas)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90 font-medium">
                                {{ $kelas->tajuk_kelas }}
                                @if($kelas->mod_kelas === 'online' && $kelas->pautan_online)
                                    <div class="text-xs text-brand-500">
                                        <a href="{{ $kelas->pautan_online }}" target="_blank" class="hover:underline">Pautan: {{ $kelas->pautan_online }}</a>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $kelas->guru ? $kelas->guru->name : '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="text-xs">Mula: {{ $kelas->masa_mula->format('d/m/Y h:i A') }}</div>
                                <div class="text-xs">Tamat: {{ $kelas->masa_tamat->format('d/m/Y h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                @if($kelas->mod_kelas === 'online')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">Online</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">Fizikal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($kelas->status === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">Aktif</span>
                                @elseif($kelas->status === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-white/[0.05] dark:text-gray-400">Selesai</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/20 dark:text-red-400">Batal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 flex items-center gap-3">
                                <a href="/kehadirans?kelas_id={{ $kelas->id }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Kehadiran</a>
                                <button wire:click="openForm({{ $kelas->id }})" class="text-brand-500 hover:text-brand-600 font-medium">Edit</button>
                                <button onclick="confirm('Adakah anda pasti mahu memadam kelas ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $kelas->id }})" class="text-red-500 hover:text-red-600 font-medium">Padam</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tiada rekod kelas dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $kelases->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $kelasId ? 'Kemaskini Kelas' : 'Tambah Kelas Baru' }}
                    </h3>
                    <button wire:click="closeForm()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Tajuk Kelas</label>
                        <input type="text" wire:model="tajuk_kelas" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: Kelas Fardhu Ain Mualaf" />
                        @error('tajuk_kelas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Guru APIM</label>
                        <select wire:model="guru_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->name }} ({{ $g->email }})</option>
                            @endforeach
                        </select>
                        @error('guru_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Mod Kelas</label>
                            <select wire:model.live="mod_kelas" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                                <option value="fizikal">Fizikal</option>
                                <option value="online">Online</option>
                            </select>
                            @error('mod_kelas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Status</label>
                            <select wire:model="status" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Batal</option>
                            </select>
                            @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($mod_kelas === 'online')
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Pautan Kelas Online (Google Meet, etc.)</label>
                            <input type="text" wire:model="pautan_online" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: https://meet.google.com/abc-defg-hij" />
                            @error('pautan_online') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Masa Mula</label>
                            <input type="datetime-local" wire:model="masa_mula" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                            @error('masa_mula') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Masa Tamat</label>
                            <input type="datetime-local" wire:model="masa_tamat" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                            @error('masa_tamat') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
</div>
