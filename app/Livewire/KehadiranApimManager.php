<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KelasApim;
use App\Models\Mualaf;
use App\Models\KehadiranApim;
use Carbon\Carbon;

class KehadiranApimManager extends Component
{
    public $kelasId;
    public $kelas;
    public $search = '';

    public function mount($kelas_id = null)
    {
        $this->kelasId = $kelas_id ?: request()->query('kelas_id');
        if ($this->kelasId) {
            $this->kelas = KelasApim::with('guru')->findOrFail($this->kelasId);
        }
    }

    public function toggleAttendance($mualafId, $status)
    {
        if (!$this->kelas) return;

        $kehadiran = KehadiranApim::updateOrCreate(
            [
                'kelas_id' => $this->kelasId,
                'mualaf_id' => $mualafId,
            ],
            [
                'status_hadir' => (bool) $status,
                'waktu_rekod' => $status ? Carbon::now() : null,
            ]
        );

        session()->flash('message', 'Kehadiran mualaf dikemaskini!');
    }

    public function render()
    {
        // Get all mualafs matching the search filter
        $mualafs = Mualaf::with('kariah')
            ->where('nama_penuh', 'like', '%' . $this->search . '%')
            ->orderBy('nama_penuh')
            ->get();

        // Get existing attendance status map for this class
        $attendances = [];
        if ($this->kelasId) {
            $attendances = KehadiranApim::where('kelas_id', $this->kelasId)
                ->pluck('status_hadir', 'mualaf_id')
                ->toArray();
        }

        return view('livewire.kehadiran-apim-manager', [
            'mualafs' => $mualafs,
            'attendances' => $attendances,
            'kelases' => KelasApim::orderBy('tajuk_kelas')->get()
        ]);
    }
}
