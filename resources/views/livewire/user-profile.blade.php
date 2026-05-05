<div class="space-y-6">
    <!-- Profil Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white lg:mb-7">Maklumat Profil</h3>
        
        @if (session()->has('profile_message'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
                {{ session('profile_message') }}
            </div>
        @endif

        <form wire:submit.prevent="updateProfile" onsubmit="event.preventDefault();" class="space-y-4">
            <!-- Gambar Profil -->
            <div class="flex items-center gap-5 pb-4 border-b border-gray-100 dark:border-gray-800 mb-4">
                <div class="relative h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800 bg-gray-50">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover object-center" />
                    @elseif ($profile_photo_path)
                        <img src="{{ Storage::url($profile_photo_path) }}" alt="Avatar" class="h-full w-full object-cover object-center" />
                    @elseif (auth()->user()->hasRole('super_admin'))
                        <img src="/images/user/owner.png" alt="Dummy" class="h-full w-full object-cover object-center" />
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-500 font-bold text-xl uppercase select-none">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-800 dark:text-white/90">Ubah Gambar Profil</label>
                    <input type="file" wire:model="photo" class="mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-white/[0.05] dark:file:text-gray-300" />
                    @error('photo') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Penuh</label>
                <input type="text" wire:model.live="name" value="{{ $name }}" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Pengguna (Username)</label>
                <input type="text" wire:model.live="username" value="{{ $username }}" placeholder="Contoh: amir_dakwah" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                @error('username') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">No. Kad Pengenalan</label>
                <input type="text" wire:model.live="no_ic" value="{{ $no_ic }}" placeholder="Contoh: 900101012345" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                @error('no_ic') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Alamat E-mel</label>
                <input type="email" wire:model.live="email" value="{{ $email }}" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Password Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white lg:mb-7">Tukar Kata Laluan</h3>

        @if (session()->has('password_message'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
                {{ session('password_message') }}
            </div>
        @endif

        <form wire:submit.prevent="updatePassword" onsubmit="event.preventDefault();" class="space-y-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Kata Laluan Semasa</label>
                <input type="password" wire:model="current_password" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                @error('current_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Kata Laluan Baru</label>
                <input type="password" wire:model="password" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Sahkan Kata Laluan Baru</label>
                <input type="password" wire:model="password_confirmation" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                    Kemas Kini Kata Laluan
                </button>
            </div>
        </form>
    </div>
</div>
