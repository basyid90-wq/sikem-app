<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KelasApim;

class DashboardGuru extends Component
{
    public function render()
    {
        $jumlahKelas = KelasApim::where('guru_id', auth()->id())
            ->whereMonth('masa_mula', now()->month)
            ->count();

        // Assumption of 150 per class for APIM
        $jumlahElaun = $jumlahKelas * 150.00;

        $upcomingClasses = KelasApim::where('guru_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard-guru', [
            'jumlahKelas' => $jumlahKelas,
            'jumlahElaun' => $jumlahElaun,
            'upcomingClasses' => $upcomingClasses,
        ]);
    }
}
