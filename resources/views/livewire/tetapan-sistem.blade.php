<div class="space-y-6 max-w-4xl mx-auto py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tetapan Sistem</h2>
        <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Konfigurasi tetapan global aplikasi SiKEM.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="simpanTetapan" class="space-y-6">
        <!-- 1. Kadar Elaun APIM -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">1. Kadar Elaun APIM</h3>
            <div class="space-y-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Kadar Elaun APIM (RM)</label>
                    <input type="text" wire:model="elaun_apim" placeholder="Contoh: 150.00" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                </div>
            </div>
        </div>

        <!-- 2. Maklumat Pegawai Pengesah -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">2. Maklumat Pegawai Pengesah (PDF)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Pegawai</label>
                    <input type="text" wire:model="pegawai_nama" placeholder="Contoh: Ustaz Ahmad bin Basri" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Jawatan Pegawai</label>
                    <input type="text" wire:model="pegawai_jawatan" placeholder="Contoh: Pegawai Hal Ehwal Islam" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                </div>
            </div>
        </div>

        <!-- 3. Tetapan API WhatsApp -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">3. Tetapan API WhatsApp</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">API Key</label>
                    <input type="text" wire:model="whatsapp_api_key" placeholder="Contoh: your-whatsapp-api-key" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Instance ID</label>
                    <input type="text" wire:model="whatsapp_instance_id" placeholder="Contoh: instance-xxxxxx" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="rounded-lg bg-brand-500 px-6 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
                Simpan Semua Tetapan
            </button>
        </div>
    </form>
</div>
