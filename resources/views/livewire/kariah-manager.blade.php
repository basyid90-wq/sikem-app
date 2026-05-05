<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Kariah (Direktori Masjid/Surau)
        </h2>
        <button wire:click="openForm()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H5a1 1 0 110-2h3V6a1 1 0 011-1z" />
            </svg>
            Tambah Kariah
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
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama kariah atau zon..." class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-12 pr-4 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
            </div>
        </div>
    </div>

    <!-- Listing Section -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white w-12 text-center">No.</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Nama Kariah</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Zon Daerah</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Nama AJK</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">No. Telefon</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($kariahs as $kariah)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">{{ ($kariahs->currentPage() - 1) * $kariahs->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $kariah->nama_kariah }}</div>
                                <span class="text-xs text-gray-500">{{ $kariah->alamat }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $kariah->zon_daerah }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $kariah->nama_ajk ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $kariah->no_telefon ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 flex items-center gap-3">
                                <button wire:click="openForm({{ $kariah->id }})" class="text-brand-500 hover:text-brand-600 font-medium">Edit</button>
                                <button onclick="confirm('Adakah anda pasti mahu memadam kariah ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $kariah->id }})" class="text-red-500 hover:text-red-600 font-medium">Padam</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tiada rekod kariah dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $kariahs->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $kariahId ? 'Kemaskini Kariah' : 'Tambah Kariah Baru' }}
                    </h3>
                    <button wire:click="closeForm()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Kariah</label>
                        <input type="text" wire:model="nama_kariah" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: Masjid Jamek Beruas" />
                        @error('nama_kariah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Zon Daerah</label>
                        <input type="text" wire:model="zon_daerah" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: Manjung" />
                        @error('zon_daerah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Alamat</label>
                        <textarea wire:model="alamat" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" rows="3" placeholder="Contoh: Lot 123, Mukim Beruas..."></textarea>
                        @error('alamat') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama AJK (Contact Person)</label>
                            <input type="text" wire:model="nama_ajk" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: Haji Ahmad" />
                            @error('nama_ajk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">No. Telefon</label>
                            <input type="text" wire:model="no_telefon" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: 0123456789" />
                            @error('no_telefon') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
