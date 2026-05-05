<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Tuntutan & Bantuan
        </h2>
        <div class="flex items-center gap-3">
            <button wire:click="generateClassAllowances()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-brand-500 bg-white px-5 py-3 text-sm font-medium text-brand-500 transition hover:bg-brand-50 dark:bg-gray-800 dark:border-brand-500 dark:hover:bg-brand-900/10">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Jana Tuntutan Elaun Kelas
            </button>
            <button wire:click="openForm()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H5a1 1 0 110-2h3V6a1 1 0 011-1z" />
                </svg>
                Hantar Tuntutan Baru
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Filters Section -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tapis Status:</label>
                <select wire:model.live="filterStatus" class="rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="lulus_kudd">Lulus KUDD</option>
                    <option value="selesai_maipk">Selesai MAIPK</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Listings Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Jenis Tuntutan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Pemohon</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Jumlah (RM)</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tarikh Tuntutan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($tuntutans as $t)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90 capitalize font-medium">
                                {{ str_replace('_', ' ', $t->jenis_tuntutan) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $t->pemohon ? $t->pemohon->name : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">
                                RM {{ number_format($t->jumlah_tuntutan, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $t->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($t->status_tuntutan === 'pending')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">Pending</span>
                                @elseif($t->status_tuntutan === 'lulus_kudd')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">Lulus KUDD</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">Selesai MAIPK</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm flex items-center gap-3">
                                @if($t->status_tuntutan === 'pending')
                                    <button wire:click="approveKUDD({{ $t->id }})" class="text-blue-600 hover:text-blue-700 font-medium">Lulus KUDD</button>
                                @elseif($t->status_tuntutan === 'lulus_kudd')
                                    <button wire:click="completeMAIPK({{ $t->id }})" class="text-emerald-600 hover:text-emerald-700 font-medium">Selesai MAIPK</button>
                                @endif
                                <button wire:click="openForm({{ $t->id }})" class="text-brand-500 hover:text-brand-600 font-medium">Edit</button>
                                <button onclick="confirm('Adakah anda pasti mahu memadam tuntutan ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $t->id }})" class="text-red-500 hover:text-red-600 font-medium">Padam</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tiada rekod tuntutan dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $tuntutans->links() }}
        </div>
    </div>

    <!-- Tuntutan Form Modal -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $tuntutanId ? 'Kemaskini Maklumat Tuntutan' : 'Hantar Tuntutan Baru' }}
                    </h3>
                    <button wire:click="closeForm()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Jenis Tuntutan</label>
                        <select wire:model.live="jenis_tuntutan" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                            <option value="khairat_kematian">Khairat Kematian</option>
                            <option value="elaun_kelas">Elaun Kelas</option>
                        </select>
                        @error('jenis_tuntutan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Jumlah Tuntutan (RM)</label>
                        <input type="number" step="0.01" wire:model="jumlah_tuntutan" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: 1500.00" />
                        @error('jumlah_tuntutan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Status Tuntutan</label>
                        <select wire:model="status_tuntutan" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                            <option value="pending">Pending</option>
                            <option value="lulus_kudd">Lulus KUDD</option>
                            <option value="selesai_maipk">Selesai MAIPK</option>
                        </select>
                        @error('status_tuntutan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    @if($jenis_tuntutan === 'khairat_kematian')
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Muat Naik Resit Tuntutan (Jika Ada)</label>
                            <input type="file" wire:model="resit" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                            @error('resit') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                            @if($resit_path)
                                <div class="mt-2 text-xs">
                                    <a href="{{ Storage::url($resit_path) }}" target="_blank" class="text-brand-500 hover:underline">Lihat Fail Resit Terkini</a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-5">
                        <button type="button" wire:click="closeForm()" class="px-5 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition">Simpan Tuntutan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
