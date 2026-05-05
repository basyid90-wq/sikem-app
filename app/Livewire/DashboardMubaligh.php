<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kematian;
use App\Models\Tuntutan;
use App\Models\Mualaf;

class DashboardMubaligh extends Component
{
    public function render()
    {
        $jumlahMualaf = Mualaf::count();
        $tuntutanBelumSelesai = Tuntutan::where('status_tuntutan', 'pending')->count();
        $jumlahTuntutanRM = Tuntutan::sum('jumlah_tuntutan');

        // Fetch all mualafs to calculate Ziarah status
        $allMualafs = Mualaf::with(['ziarahLogs' => function ($q) {
            $q->latest('tarikh_ziarah');
        }])->get();

        $mualafPerluDiziarah = 0;
        $mualafKritikal = collect();

        foreach ($allMualafs as $m) {
            $latestLog = $m->ziarahLogs->first();
            $needsZiarah = false;
            $status = 'red';
            $tarikh = 'Tiada Rekod';

            if (!$latestLog) {
                $needsZiarah = true;
                $status = 'red';
            } else {
                $tarikh = $latestLog->tarikh_ziarah->format('d/m/Y');
                $diffInMonths = $latestLog->tarikh_ziarah->diffInMonths(now());
                if ($diffInMonths > 6) {
                    $needsZiarah = true;
                    $status = 'yellow';
                }
            }

            if ($needsZiarah) {
                $mualafPerluDiziarah++;
                $mualafKritikal->push((object)[
                    'id' => $m->id,
                    'nama_penuh' => $m->nama_penuh,
                    'no_ic' => $m->no_ic,
                    'tarikh_ziarah' => $tarikh,
                    'status' => $status
                ]);
            }
        }

        $mualafKritikal = $mualafKritikal->take(10);

        $kematians = Kematian::with('mualaf')
            ->where('pelapor_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        if ($kematians->isEmpty()) {
            $kematians = Kematian::with('mualaf')
                ->latest()
                ->take(5)
                ->get();
        }

        $tuntutans = Tuntutan::where('pemohon_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        if ($tuntutans->isEmpty()) {
            $tuntutans = Tuntutan::latest()->take(5)->get();
        }

        return view('livewire.dashboard-mubaligh', [
            'jumlahMualaf' => $jumlahMualaf,
            'mualafPerluDiziarah' => $mualafPerluDiziarah,
            'tuntutanBelumSelesai' => $tuntutanBelumSelesai,
            'jumlahTuntutanRM' => $jumlahTuntutanRM,
            'mualafKritikal' => $mualafKritikal,
            'kematians' => $kematians,
            'tuntutans' => $tuntutans,
        ]);
    }
}
