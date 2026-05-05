<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Tuntutan;
use App\Models\User;
use App\Models\KehadiranApim;
use App\Models\Mualaf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TuntutanManager extends Component
{
    use WithPagination, WithFileUploads;

    // Filter
    public $filterStatus = '';

    // Form fields
    public $tuntutanId;
    public $jenis_tuntutan = 'khairat_kematian';
    public $reference_id;
    public $jumlah_tuntutan;
    public $status_tuntutan = 'pending';
    public $resit; // for file upload
    public $resit_path;

    public $isFormOpen = false;

    protected $rules = [
        'jenis_tuntutan' => 'required|in:khairat_kematian,elaun_kelas',
        'reference_id' => 'nullable|integer',
        'jumlah_tuntutan' => 'required|numeric|min:0',
        'status_tuntutan' => 'required|in:pending,lulus_kudd,selesai_maipk',
        'resit' => 'nullable|image|max:2048',
    ];

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->reset(['jenis_tuntutan', 'reference_id', 'jumlah_tuntutan', 'status_tuntutan', 'resit', 'resit_path']);
        $this->tuntutanId = $id;

        if ($id) {
            $t = Tuntutan::findOrFail($id);
            $this->jenis_tuntutan = $t->jenis_tuntutan;
            $this->reference_id = $t->reference_id;
            $this->jumlah_tuntutan = $t->jumlah_tuntutan;
            $this->status_tuntutan = $t->status_tuntutan;
            $this->resit_path = $t->resit_path;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'jenis_tuntutan' => $this->jenis_tuntutan,
            'reference_id' => $this->reference_id,
            'pemohon_id' => Auth::id(),
            'jumlah_tuntutan' => $this->jumlah_tuntutan,
            'status_tuntutan' => $this->status_tuntutan,
        ];

        if ($this->resit) {
            $path = $this->resit->store('resit_tuntutans', 'public');
            $data['resit_path'] = $path;
        }

        if ($this->tuntutanId) {
            Tuntutan::findOrFail($this->tuntutanId)->update($data);
            session()->flash('message', 'Tuntutan berjaya dikemaskini!');
        } else {
            Tuntutan::create($data);
            session()->flash('message', 'Tuntutan baru berjaya dihantar!');
        }

        $this->closeForm();
    }

    public function generateClassAllowances()
    {
        // 1. Get current month/year
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // 2. Count total classes attended by ALL mualafs
        $attendedCount = KehadiranApim::where('status_hadir', true)
            ->whereBetween('waktu_rekod', [$start, $end])
            ->count();

        if ($attendedCount === 0) {
            session()->flash('message', 'Tiada kehadiran kelas APIM dicatatkan untuk bulan ini.');
            return;
        }

        // RM10 per attendance
        $totalAmount = $attendedCount * 10.00;

        // 3. Create claims entry for teacher (Auth user)
        Tuntutan::create([
            'jenis_tuntutan' => 'elaun_kelas',
            'reference_id' => null,
            'pemohon_id' => Auth::id(),
            'jumlah_tuntutan' => $totalAmount,
            'status_tuntutan' => 'pending',
        ]);

        session()->flash('message', 'Tuntutan elaun kelas RM ' . number_format($totalAmount, 2) . ' dijana secara automatik berdasarkan ' . $attendedCount . ' kehadiran bulan ini!');
    }

    public function approveKUDD($id)
    {
        Tuntutan::findOrFail($id)->update(['status_tuntutan' => 'lulus_kudd']);
        session()->flash('message', 'Tuntutan diluluskan oleh KUDD!');
    }

    public function completeMAIPK($id)
    {
        Tuntutan::findOrFail($id)->update(['status_tuntutan' => 'selesai_maipk']);
        session()->flash('message', 'Tuntutan disahkan selesai oleh MAIPK!');
    }

    public function delete($id)
    {
        Tuntutan::findOrFail($id)->delete();
        session()->flash('message', 'Tuntutan berjaya dipadam!');
    }

    public function render()
    {
        $query = Tuntutan::with('pemohon');

        if ($this->filterStatus) {
            $query->where('status_tuntutan', $this->filterStatus);
        }

        return view('livewire.tuntutan-manager', [
            'tuntutans' => $query->latest()->paginate(10)
        ]);
    }
}
