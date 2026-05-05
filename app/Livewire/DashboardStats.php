<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mualaf;
use App\Models\KelasApim;
use App\Models\Tuntutan;
use Carbon\Carbon;

class DashboardStats extends Component
{
    public $totalMualafs = 0;
    public $totalActiveClasses = 0;
    public $totalClaimsMonth = 0;

    public function mount()
    {
        $this->totalMualafs = Mualaf::count();
        $this->totalActiveClasses = KelasApim::where('status', 'aktif')->count();
        
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $this->totalClaimsMonth = Tuntutan::whereBetween('created_at', [$start, $end])
            ->sum('jumlah_tuntutan');
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
