<div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pengurusan Pengguna & Akses
        </h2>
        <div class="flex items-center gap-3">
            <button wire:click="openForm()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H5a1 1 0 110-2h3V6a1 1 0 011-1z" />
                </svg>
                Tambah Pengguna
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 flex items-center gap-4 rounded-lg bg-red-50 p-4 text-red-800 dark:bg-red-900/20 dark:text-red-400">
            <span class="text-sm font-medium">{{ session('error') }}</span>
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
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..." class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-12 pr-4 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
            </div>
        </div>
    </div>

    <!-- Listing Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white w-12">No.</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Nama Pengguna</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Email</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Peranan (Role)</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $u->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $u->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                @if($u->roles->isNotEmpty())
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-800 dark:bg-brand-500/20 dark:text-brand-400">
                                        {{ $u->roles->pluck('name')->implode(', ') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-white/[0.05] dark:text-gray-400">
                                        Tiada Peranan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 flex items-center gap-3">
                                @if(!$u->hasRole('super_admin'))
                                    <button wire:click="viewUser({{ $u->id }})" class="text-blue-600 hover:text-blue-700 font-medium">Lihat</button>
                                @endif
                                <button wire:click="openForm({{ $u->id }})" class="text-brand-500 hover:text-brand-600 font-medium">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tiada rekod pengguna dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $userId ? 'Kemaskini Pengguna' : 'Tambah Pengguna Baru' }}
                    </h3>
                    <button wire:click="closeForm()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Nama Penuh</label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Alamat Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Kata Laluan (Password)</label>
                        <input type="password" wire:model="password" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white" />
                        @if($userId)
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Tinggalkan kosong jika tidak mahu menukar kata laluan.</span>
                        @endif
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Peranan (Role)</label>
                        <select wire:model.live="role" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                            <option value="">-- Pilih Peranan --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ ucwords(str_replace('_', ' ', $r->name)) }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    @if($role !== 'super_admin')
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-white/90">Pilih Daerah</label>
                        <select wire:model="daerah_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white">
                            <option value="">-- Pilih Daerah --</option>
                            @foreach($senarai_daerah as $daerah)
                                <option value="{{ $daerah->id }}">{{ $daerah->nama_daerah }}</option>
                            @endforeach
                        </select>
                        @error('daerah_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-5">
                        <button type="button" wire:click="closeForm()" class="px-5 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal View (Details & Reset Password) -->
    @if($isViewOpen && $selectedUser)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 dark:border dark:border-gray-800 sm:p-8 max-h-[90vh] overflow-y-auto">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Butiran Pengguna
                    </h3>
                    <button wire:click="closeView()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.811 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.811z"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Nama Penuh</span>
                        <p class="text-sm text-gray-800 dark:text-white mt-0.5 font-medium">{{ $selectedUser->name }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Alamat Email</span>
                        <p class="text-sm text-gray-800 dark:text-white mt-0.5 font-medium">{{ $selectedUser->email }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Username</span>
                        <p class="text-sm text-gray-800 dark:text-white mt-0.5 font-medium">{{ $selectedUser->username ?? '-' }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">No. Kad Pengenalan</span>
                        <p class="text-sm text-gray-800 dark:text-white mt-0.5 font-medium">{{ $selectedUser->no_ic ?? '-' }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Peranan</span>
                        <p class="text-sm text-gray-800 dark:text-white mt-0.5 font-medium">
                            {{ $selectedUser->roles->pluck('name')->implode(', ') ?: 'Tiada Peranan' }}
                        </p>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-800 pt-5 mt-5">
                        <button type="button" 
                                onclick="confirm('Adakah anda pasti untuk me-reset kata laluan pengguna ini ke default?') || event.stopImmediatePropagation()" 
                                wire:click="resetPasswordDefault({{ $selectedUser->id }})" 
                                class="w-full rounded-lg bg-rose-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-rose-700 text-center">
                            Reset Kata Laluan ke Default (sikem1234)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
