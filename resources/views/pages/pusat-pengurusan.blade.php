@extends('layouts.app')

@section('content')
<div class="space-y-8" x-data="{ activeTab: '{{ auth()->user()->hasRole('super_admin') ? 'developer' : 'operasi' }}' }">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Pusat Pengurusan (Portal Menu)</h2>
    </div>

    <!-- Bahagian Header Tabs (Navigasi) -->
    @role('super_admin')
    <div class="flex space-x-8 border-b border-gray-200 dark:border-gray-700 mb-6">
        <button @click="activeTab = 'developer'"
                :class="activeTab === 'developer' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors duration-300 flex items-center gap-2">
            🛠️ Alat Pentadbir
        </button>
        <button @click="activeTab = 'operasi'"
                :class="activeTab === 'operasi' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors duration-300 flex items-center gap-2">
            🏢 Modul Operasi
        </button>
    </div>
    @endrole

    <!-- Tab 1: Alat Pentadbir -->
    @role('super_admin')
    <div x-cloak x-show="activeTab === 'developer'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
        <!-- KATEGORI 5: PENTADBIRAN SISTEM -->
        @hasanyrole('super_admin|kudd|mubaligh|guru_apim')
        <div>
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Kategori 5: Pentadbiran Sistem</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Kad 1: Pengurusan Pengguna & Akses -->
                <a href="/users" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Pengurusan Pengguna</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Kawalan pengguna dan peranan (roles)</p>
                        </div>
                    </div>
                </a>

                <!-- Kad 2: Sistem Log (Error) -->
                @role('super_admin')
                <a href="/log-viewer" target="_blank" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Sistem Log (Error)</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Sistem semakan log ralat</p>
                        </div>
                    </div>
                </a>
                @endrole
            </div>
        </div>
        @endhasanyrole
    </div>
    @endrole

    <!-- Tab 2: Modul Operasi -->
    <div x-cloak x-show="activeTab === 'operasi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
        <!-- KATEGORI 1: PANGKALAN DATA -->
        @hasanyrole('super_admin|kudd|mubaligh|guru_apim')
        <div>
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Kategori 1: Pangkalan Data</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Kad 1: Direktori Kariah -->
                <a href="/kariahs" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Direktori Kariah</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Pengurusan maklumat Kariah</p>
                        </div>
                    </div>
                </a>

                <!-- Kad 2: Profil Mualaf -->
                <a href="/mualafs" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Profil Mualaf</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Data pendaftaran dan dokumen</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endhasanyrole

        <!-- KATEGORI 2: PENDIDIKAN APIM -->
        @hasanyrole('super_admin|kudd|mubaligh|guru_apim')
        <div>
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Kategori 2: Pendidikan APIM</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Kad 1: Pengurusan Kelas -->
                <a href="/kelas" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Pengurusan Kelas</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Kelas fizikal dan online</p>
                        </div>
                    </div>
                </a>

                <!-- Kad 2: Rekod Kehadiran -->
                <a href="/kehadirans" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Rekod Kehadiran</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Kehadiran & penyertaan murid</p>
                        </div>
                    </div>
                </a>

                <!-- Kad 3: Ziarah & Silaturahim -->
                @hasanyrole('super_admin|kudd|mubaligh')
                <a href="/ziarah" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Ziarah & Silaturahim</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Rekod lawatan dan santunan</p>
                        </div>
                    </div>
                </a>
                @endhasanyrole
            </div>
        </div>
        @endhasanyrole

        <!-- KATEGORI 3: PENGURUSAN JENAZAH -->
        @hasanyrole('super_admin|kudd|mubaligh')
        <div>
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Kategori 3: Pengurusan Jenazah</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Kad 1: Lapor Kematian -->
                <a href="/kematians" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Lapor Kematian</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Borang triage pelaporan kes</p>
                        </div>
                    </div>
                </a>

                <!-- Kad 2: Senarai Kes & Surat -->
                <a href="/kematians" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Senarai Kes & Surat</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Pengurusan surat kuasa wakil</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endhasanyrole

        <!-- KATEGORI 4: KEWANGAN & TUNTUTAN -->
        @hasanyrole('super_admin|kudd|mubaligh|guru_apim')
        <div>
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Kategori 4: Kewangan & Tuntutan</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Kad 1: Tuntutan Khairat & Elaun -->
                <a href="/tuntutans" class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 hover:border-brand-500 hover:shadow-theme-md transition-all duration-300 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><line x1="6" y1="12" x2="6.01" y2="12"></line><line x1="18" y1="12" x2="18.01" y2="12"></line></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 group-hover:text-brand-600 transition-colors dark:text-white">Tuntutan</h4>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Bantuan khairat dan elaun APIM</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endhasanyrole
    </div>
</div>
@endsection
