<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Kematian (Modul Pengurusan Jenazah)
        </h2>
        <button wire:click="openForm()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H5a1 1 0 110-2h3V6a1 1 0 011-1z" />
            </svg>
            Laporkan Kematian
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Listing & Search Section -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama mualaf..." class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-12 pr-4 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Mualaf Terlibat</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tarikh Mati</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Lokasi</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Status Kes</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Kariah</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($kematians as $kematian)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $kematian->mualaf ? $kematian->mualaf->nama_penuh : '-' }}
                                </div>
                                <div class="text-xs text-gray-500">IC: {{ $kematian->mualaf ? $kematian->mualaf->no_ic : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $kematian->tarikh_mati ? $kematian->tarikh_mati->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $kematian->lokasi_mati }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($kematian->status_kes === 'baru')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">Baru</span>
                                @elseif($kematian->status_kes === 'dalam_proses')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">Dalam Proses</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-white/[0.05] dark:text-gray-400">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                @if($kematian->kariah_dimaklumkan)
                                    <span class="text-xs text-emerald-600 font-medium">Sudah Dimaklum</span>
                                @else
                                    @if($kematian->mualaf && $kematian->mualaf->kariah)
                                        <a href="{{ $this->getWhatsappLink($kematian->id) }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-300 rounded px-2 py-1 font-medium">Maklumkan Kariah</a>
                                    @else
                                        <span class="text-xs text-gray-400">Kariah Tiada</span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 flex items-center gap-3">
                                <button wire:click="openForm({{ $kematian->id }})" class="text-brand-500 hover:text-brand-600 font-medium">Triage / Edit</button>
                                <button onclick="confirm('Adakah anda pasti mahu memadam kes kematian ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $kematian->id }})" class="text-red-500 hover:text-red-600 font-medium">Padam</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tiada rekod kes kematian dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $kematians->links() }}
        </div>
    </div>

    <!-- Triage Form / Modal -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-4xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $kematianId ? 'Borang Triage & Maklumat Kes' : 'Laporkan Kematian Baru' }}
                    </h3>
                    <button wire:click="closeForm()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Left side -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Mualaf</label>
                                <select wire:model="mualaf_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                                    <option value="">-- Pilih Mualaf --</option>
                                    @foreach($mualafs as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_penuh }} (IC: {{ $m->no_ic }})</option>
                                    @endforeach
                                </select>
                                @error('mualaf_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Tarikh Kematian</label>
                                    <input type="date" wire:model="tarikh_mati" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                                    @error('tarikh_mati') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Status Kes</label>
                                    <select wire:model="status_kes" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                                        <option value="baru">Baru</option>
                                        <option value="dalam_proses">Dalam Proses</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    @error('status_kes') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Lokasi Kematian</label>
                                <input type="text" wire:model="lokasi_mati" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" placeholder="Contoh: Hospital Seri Manjung" />
                                @error('lokasi_mati') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-800 dark:text-white/90">Tuntutan Waris Non-Muslim?</label>
                                <input type="checkbox" wire:model="status_tuntutan_non" class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500" />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nota Log / Siasatan</label>
                                <textarea wire:model="nota_log" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" rows="3" placeholder="Nota rundingan waris / kronologi"></textarea>
                                @error('nota_log') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Fail & Dokumen Sokongan</h4>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Muat Naik Laporan Polis (Polis Report)</label>
                                <input type="file" wire:model="polis_report" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                                @error('polis_report') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                                @if($polis_report_path)
                                    <div class="mt-2 text-xs">
                                        <a href="{{ Storage::url($polis_report_path) }}" target="_blank" class="text-brand-500 hover:underline">Lihat Laporan Polis Terkini</a>
                                    </div>
                                @endif
                            </div>

                            @if($kematianId)
                                <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Surat Kuasa Wakil Pejabat Agama</h4>
                                    <p class="text-xs text-gray-500 mb-2">Auto-generate surat wakil rasmi pejabat agama.</p>
                                    
                                    <button type="button" wire:click="generateLetter({{ $kematianId }})" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-4 py-2.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition border border-emerald-200">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                                        Jana Surat Wakil
                                    </button>

                                    @if($surat_wakil_path)
                                        <div class="mt-2 text-xs">
                                            <a href="{{ Storage::url($surat_wakil_path) }}" target="_blank" class="text-brand-500 hover:underline font-medium">Muat Turun Surat Wakil (.pdf)</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-5">
                        <button type="button" wire:click="closeForm()" class="px-5 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition">Simpan Kes</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
