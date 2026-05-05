<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mualaf;
use App\Models\KelasApim;
use App\Models\Tuntutan;
use App\Models\User;
use App\Models\Kematian;

class DashboardKudd extends Component
{
    public function render()
    {
        $jumlahMualaf = Mualaf::count();
        $kelasAktif = KelasApim::where('status', 'aktif')->count();
        $tuntutanBelumSelesai = Tuntutan::where('status_tuntutan', 'pending')->count();
        $jumlahTuntutanRM = Tuntutan::sum('jumlah_tuntutan');
        $jumlahGuruApim = User::whereHas('roles', function ($q) {
            $q->where('name', 'guru_apim');
        })->count();

        $kematians = Kematian::with(['mualaf', 'pelapor'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard-kudd', [
            'jumlahMualaf' => $jumlahMualaf,
            'kelasAktif' => $kelasAktif,
            'tuntutanBelumSelesai' => $tuntutanBelumSelesai,
            'jumlahTuntutanRM' => $jumlahTuntutanRM,
            'jumlahGuruApim' => $jumlahGuruApim,
            'kematians' => $kematians,
        ]);
    }
}
