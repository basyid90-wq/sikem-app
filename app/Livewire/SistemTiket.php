<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ticket;
use App\Models\TicketReply;

class SistemTiket extends Component
{
    use WithFileUploads;

    public $tajuk;
    public $kategori = 'Isu Paparan';
    public $deskripsi;
    public $gambar;

    public $filterStatus = 'all';
    public $search = '';
    public $isFormOpen = false;

    public $selectedTicketId = null;
    public $replyMessage = '';

    public function mount(\Illuminate\Http\Request $request)
    {
        if ($request->has('ticket_id')) {
            $this->selectedTicketId = $request->query('ticket_id');
        }
    }

    public function selectTicket($id)
    {
        $this->selectedTicketId = $id;
        $this->replyMessage = '';
    }

    public function deselectTicket()
    {
        $this->selectedTicketId = null;
        $this->replyMessage = '';
    }

    public function hantarReply()
    {
        if (empty($this->replyMessage)) {
            return;
        }

        TicketReply::create([
            'ticket_id' => $this->selectedTicketId,
            'user_id' => auth()->id(),
            'message' => $this->replyMessage
        ]);

        $ticket = Ticket::find($this->selectedTicketId);

        if (auth()->user()->hasRole('super_admin')) {
            // Notify ticket owner
            \DB::table('notifications')->insert([
                'id' => (string) \Str::uuid(),
                'type' => 'App\Notifications\TicketNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $ticket->user_id,
                'data' => json_encode([
                    'message' => 'Maklum balas baru dari Admin untuk tiket #' . $ticket->id,
                    'url' => route('lapor-isu', ['ticket_id' => $ticket->id])
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            // Notify super admins
            $superAdmins = \App\Models\User::whereHas('roles', function($q) {
                $q->where('name', 'super_admin');
            })->get();

            foreach ($superAdmins as $admin) {
                \DB::table('notifications')->insert([
                    'id' => (string) \Str::uuid(),
                    'type' => 'App\Notifications\TicketNotification',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $admin->id,
                    'data' => json_encode([
                        'message' => 'Maklum balas baru dari ' . auth()->user()->name . ' untuk tiket #' . $ticket->id,
                        'url' => route('lapor-isu', ['ticket_id' => $ticket->id])
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $this->replyMessage = '';
        session()->flash('ticket_message', 'Mesej balasan anda telah berjaya dihantar!');
    }

    public function setFilter($status)
    {
        $this->filterStatus = $status;
    }

    public function openForm()
    {
        $this->resetValidation();
        $this->reset(['tajuk', 'deskripsi', 'gambar']);
        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
    }

    public function simpanTiket()
    {
        $this->validate([
            'tajuk' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambar_path = null;
        if ($this->gambar) {
            $gambar_path = $this->gambar->store('tickets', 'public');
        }

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'tajuk' => $this->tajuk,
            'kategori' => $this->kategori,
            'deskripsi' => $this->deskripsi,
            'gambar_path' => $gambar_path,
            'status' => 'baru',
        ]);

        // Notify super admins
        $superAdmins = \App\Models\User::whereHas('roles', function($q) {
            $q->where('name', 'super_admin');
        })->get();

        foreach ($superAdmins as $admin) {
            \DB::table('notifications')->insert([
                'id' => (string) \Str::uuid(),
                'type' => 'App\Notifications\TicketNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $admin->id,
                'data' => json_encode([
                    'message' => 'Tiket baru #' . $ticket->id . ' telah dilaporkan oleh ' . auth()->user()->name,
                    'url' => route('lapor-isu', ['ticket_id' => $ticket->id])
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->reset(['tajuk', 'deskripsi', 'gambar']);
        $this->isFormOpen = false;
        session()->flash('ticket_message', 'Tiket / Laporan isu anda telah berjaya dihantar!');
    }

    public function updateTicketStatus($ticketId, $status)
    {
        if (!auth()->user()->hasRole('super_admin')) {
            return;
        }

        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->update(['status' => $status]);
            session()->flash('ticket_message', 'Status tiket berjaya dikemaskini!');
        }
    }

    public function render()
    {
        if ($this->selectedTicketId) {
            $ticket = Ticket::with(['user', 'replies.user'])->find($this->selectedTicketId);
            return view('livewire.ticket-thread', [
                'ticket' => $ticket
            ])->extends('layouts.app')->section('content');
        }

        $query = Ticket::query()->with('user');

        if (!auth()->user()->hasRole('super_admin')) {
            $query->where('user_id', auth()->id());
        }

        if ($this->filterStatus === 'pending') {
            $query->whereIn('status', ['baru', 'dalam_tindakan']);
        } elseif ($this->filterStatus === 'solved') {
            $query->where('status', 'selesai');
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('tajuk', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        $tickets = $query->latest()->get();

        // Stats
        $baseStatsQuery = Ticket::query();
        if (!auth()->user()->hasRole('super_admin')) {
            $baseStatsQuery->where('user_id', auth()->id());
        }

        $totalTickets = (clone $baseStatsQuery)->count();
        $pendingTickets = (clone $baseStatsQuery)->whereIn('status', ['baru', 'dalam_tindakan'])->count();
        $solvedTickets = (clone $baseStatsQuery)->where('status', 'selesai')->count();

        return view('livewire.sistem-tiket', [
            'tickets' => $tickets,
            'totalTickets' => $totalTickets,
            'pendingTickets' => $pendingTickets,
            'solvedTickets' => $solvedTickets,
        ])->extends('layouts.app')->section('content');
    }
}
