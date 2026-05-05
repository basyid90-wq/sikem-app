<div class="max-w-7xl mx-auto space-y-6">
    <!-- Top Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <button wire:click="deselectTicket" class="inline-flex items-center justify-center h-10 w-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 shadow-sm" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </button>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Balas Tiket Sokongan</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Berbual dan bincang untuk selesaikan isu ini</p>
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="/" class="hover:text-brand-500">Home</a>
            <span>&gt;</span>
            <button wire:click="deselectTicket" class="hover:text-brand-500">Sistem Tiket</button>
            <span>&gt;</span>
            <span class="text-gray-800 dark:text-white font-medium">Balas Tiket</span>
        </div>
    </div>

    @if (session()->has('ticket_message'))
        <div class="mb-4 flex items-center gap-4 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 dark:bg-emerald-900/20 dark:border-emerald-800/40 dark:text-emerald-400">
            <svg class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-medium">{{ session('ticket_message') }}</span>
        </div>
    @endif

    <!-- Main Discussion Content & Sidebar Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Conversation Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tiket #{{ $ticket->id }}</span>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-0.5">{{ $ticket->tajuk }}</h3>
                        <span class="text-xs text-gray-400 mt-1 block">Dihantar pada {{ $ticket->created_at->format('d/m/Y \j\a\m h:i A') }}</span>
                    </div>
                    <div>
                        @if ($ticket->status === 'baru')
                            <span class="inline-flex rounded-lg bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                Baru
                            </span>
                        @elseif ($ticket->status === 'dalam_tindakan')
                            <span class="inline-flex rounded-lg bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                                Dalam Tindakan
                            </span>
                        @else
                            <span class="inline-flex rounded-lg bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                Selesai
                            </span>
                        @endif
                    </div>
                </div>

                <!-- First/Original Post by user -->
                <div class="flex items-start gap-4">
                    @if ($ticket->user?->profile_photo_path)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($ticket->user?->profile_photo_path) }}" alt="{{ $ticket->user?->name }}" class="flex h-12 w-12 rounded-full object-cover flex-shrink-0" />
                    @else
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400 flex-shrink-0 font-bold">
                            {{ strtoupper(substr($ticket->user?->name ?? 'P', 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-grow space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <div>
                                <span class="font-bold text-gray-800 dark:text-white">{{ $ticket->user?->name }}</span>
                                <span class="text-xs text-gray-400 ml-1 block">{{ $ticket->user?->email }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ticket->deskripsi }}</div>
                        @if ($ticket->gambar_path)
                            <div class="mt-2">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($ticket->gambar_path) }}" target="_blank" class="inline-block">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($ticket->gambar_path) }}" alt="Bukti Gambar" class="max-w-xs h-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:opacity-95 transition" />
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Loop through Replies -->
                @if ($ticket->replies->isNotEmpty())
                    <div class="space-y-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        @foreach ($ticket->replies as $reply)
                            <div class="flex items-start gap-4">
                                @if ($reply->user?->profile_photo_path)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($reply->user?->profile_photo_path) }}" alt="{{ $reply->user?->name }}" class="flex h-10 w-10 rounded-full object-cover flex-shrink-0" />
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full flex-shrink-0 font-bold {{ $reply->user?->hasRole('super_admin') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
                                        {{ strtoupper(substr($reply->user?->name ?? 'P', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-grow space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div>
                                            <span class="font-bold text-gray-800 dark:text-white">
                                                {{ $reply->user?->name }}
                                                @if ($reply->user?->hasRole('super_admin'))
                                                    <span class="text-xs bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800 px-2 py-0.5 rounded ml-1">Admin</span>
                                                @endif
                                            </span>
                                            <span class="text-xs text-gray-400 ml-1 block">{{ $reply->user?->email }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $reply->message }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Reply Input Box -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-4">
                <form wire:submit.prevent="hantarReply" class="space-y-3">
                    <div class="relative">
                        <textarea wire:model="replyMessage" rows="4" placeholder="Taip jawapan atau maklum balas anda di sini..." class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:text-white" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar / Ticket Details Column -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-3">Maklumat Isu / Tiket</h3>

                <div class="space-y-4">
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Customer</span>
                        <span class="text-gray-800 dark:text-white font-semibold">{{ $ticket->user?->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Email</span>
                        <span class="text-gray-800 dark:text-white font-semibold break-all text-right">{{ $ticket->user?->email }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Ticket ID</span>
                        <span class="text-gray-800 dark:text-white font-semibold">#{{ $ticket->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Category</span>
                        <span class="text-gray-800 dark:text-white font-semibold">{{ $ticket->kategori }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Created</span>
                        <span class="text-gray-800 dark:text-white font-semibold">{{ $ticket->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 dark:border-gray-700/50 items-center">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Status</span>
                        @if ($ticket->status === 'baru')
                            <span class="inline-flex rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">Baru</span>
                        @elseif ($ticket->status === 'dalam_tindakan')
                            <span class="inline-flex rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">Dalam Tindakan</span>
                        @else
                            <span class="inline-flex rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">Selesai</span>
                        @endif
                    </div>
                </div>

                @role('super_admin')
                    <!-- Quick actions to change status -->
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4 mt-4 space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Kemas kini Status Tiket</label>
                        <select wire:change="updateTicketStatus({{ $ticket->id }}, $event.target.value)" class="w-full rounded-xl border border-gray-200 bg-white dark:bg-gray-700 px-3.5 py-2.5 text-sm font-medium outline-none focus:border-brand-500 dark:border-gray-600 dark:text-white transition">
                            <option value="baru" {{ $ticket->status === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="dalam_tindakan" {{ $ticket->status === 'dalam_tindakan' ? 'selected' : '' }}>Dalam Tindakan</option>
                            <option value="selesai" {{ $ticket->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</div>
