<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use App\Models\Ticket;

class DeveloperDashboard extends Component
{
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        session()->flash('message', 'Cache sistem telah berjaya dibersihkan!');
    }

    public function optimizeSystem()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        session()->flash('message', 'Sistem berjaya dioptimumkan!');
    }

    public function updateTicketStatus($ticketId, $status)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->update(['status' => $status]);
            session()->flash('message', 'Status tiket berjaya dikemaskini!');
        }
    }

    public function render()
    {
        // memory usage
        $memoryUsage = round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB';

        // Senarai Tiket Semasa
        $currentTickets = Ticket::with('user')
            ->whereIn('status', ['baru', 'dalam_tindakan'])
            ->latest()
            ->get();

        return view('livewire.developer-dashboard', [
            'phpVersion' => phpversion(),
            'laravelVersion' => app()->version(),
            'memoryUsage' => $memoryUsage,
            'currentTickets' => $currentTickets,
        ]);
    }
}
