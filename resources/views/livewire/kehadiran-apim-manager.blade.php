<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Kehadiran (Pendidikan APIM)
        </h2>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Dropdown / Class Selector -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6 mb-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Pilih Kelas</label>
                <select wire:model.live="kelasId" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" onchange="window.location.href='/kehadirans?kelas_id=' + this.value">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id }}">{{ $k->tajuk_kelas }} ({{ $k->masa_mula->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Cari Mualaf</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama mualaf..." class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
            </div>
        </div>
    </div>

    @if($kelas)
        <!-- Class details summary -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6 mb-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $kelas->tajuk_kelas }}</h3>
                    <p class="text-sm text-gray-500">Guru: {{ $kelas->guru ? $kelas->guru->name : '-' }} | Mod: <span class="capitalize">{{ $kelas->mod_kelas }}</span></p>
                </div>
                <div class="text-right">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Tarikh Mula:</span>
                    <span class="text-sm text-gray-800 dark:text-white/90">{{ $kelas->masa_mula->format('d/m/Y h:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Attendance List Table -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Nama Mualaf</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">No. IC</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Kariah</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white text-center">Tanda Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($mualafs as $mualaf)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $mualaf->nama_penuh }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $mualaf->no_ic }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $mualaf->kariah ? $mualaf->kariah->nama_kariah : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" wire:click="toggleAttendance({{ $mualaf->id }}, $event.target.checked)" @if(!empty($attendances[$mualaf->id])) checked @endif class="h-6 w-6 rounded border-gray-300 text-brand-500 focus:ring-brand-500 cursor-pointer" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tiada rekod mualaf dijumpai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-8 text-center text-sm text-gray-500">
            Sila pilih kelas di atas terlebih dahulu untuk merekod kehadiran mualaf.
        </div>
    @endif
</div>
