<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6 2xl:gap-7.5 mb-6">
    <!-- Card 1: Total Mualaf -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex items-center justify-between">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">
                Jumlah Mualaf Berdaftar
            </span>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white">
                {{ $totalMualafs }} Orang
            </h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-brand-500/10 text-brand-500">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </div>
    </div>

    <!-- Card 2: Total Kelas Aktif -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex items-center justify-between">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">
                Jumlah Kelas Aktif (APIM)
            </span>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white">
                {{ $totalActiveClasses }} Kelas
            </h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-brand-500/10 text-brand-500">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-7 5h5v5h-5v-5z" />
            </svg>
        </div>
    </div>

    <!-- Card 3: Total Tuntutan Bulan Ini -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex items-center justify-between">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">
                Jumlah Tuntutan Bulan Ini
            </span>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white">
                RM {{ number_format($totalClaimsMonth, 2) }}
            </h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-brand-500/10 text-brand-500">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 1.21-1.04 2.01-3 2.01-2.09 0-2.81-1-2.9-2.26H6.1c.1 2.11 1.6 3.42 3.7 3.89V21h3v-2.19c2.12-.49 3.7-1.75 3.7-3.74 0-2.82-2.43-3.57-4.7-4.17z" />
            </svg>
        </div>
    </div>
</div>
