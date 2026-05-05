<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mualaf;
use App\Models\ZiarahLog;

class ZiarahManager extends Component
{
    use WithPagination;

    public $search = '';
    public $activeTab = 'kritikal';
    public $selectedKariah = '';
    public $isModalOpen = false;
    public $selectedMualafId;
    public $selectedMualaf;

    // Form variables for logging new ziarah
    public $tarikh_ziarah;
    public $tujuan;
    public $nota_hasil_ziarah;

    protected $queryString = [
        'search' => ['except' => ''],
        'activeTab' => ['except' => 'kritikal'],
        'selectedKariah' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActiveTab()
    {
        $this->resetPage();
    }

    public function updatingSelectedKariah()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Mualaf::with(['ziarahLogs' => function ($q) {
                $q->latest('tarikh_ziarah');
            }, 'kariah'])
            ->where(function($q) {
                $q->where('nama_penuh', 'like', '%' . $this->search . '%')
                  ->orWhere('no_ic', 'like', '%' . $this->search . '%');
            });

        // Filter by Kariah
        if ($this->selectedKariah) {
            $query->where('kariah_id', $this->selectedKariah);
        }

        // Filter by Tab (Priority)
        if ($this->activeTab === 'kritikal') {
            $query->where(function($q) {
                $q->whereDoesntHave('ziarahLogs')
                  ->orWhereHas('ziarahLogs', function($sub) {
                      $sub->whereIn('id', function($in) {
                          $in->selectRaw('max(id)')->from('ziarah_logs')->groupBy('mualaf_id');
                      })->where('tarikh_ziarah', '<', now()->subMonths(6));
                  });
            });
        } elseif ($this->activeTab === 'terkini') {
            $query->whereHas('ziarahLogs', function($sub) {
                $sub->whereIn('id', function($in) {
                    $in->selectRaw('max(id)')->from('ziarah_logs')->groupBy('mualaf_id');
                })->where('tarikh_ziarah', '>=', now()->subMonths(6));
            });
        }

        $mualafs = $query->latest()->paginate(10);

        return view('livewire.ziarah-manager', [
            'mualafs' => $mualafs,
            'kariahs' => \App\Models\Kariah::orderBy('nama_kariah')->get(),
            'history' => $this->selectedMualafId ? ZiarahLog::with('user')->where('mualaf_id', $this->selectedMualafId)->latest('tarikh_ziarah')->get() : []
        ])->extends('layouts.app')->section('content');
    }

    public function openLogZiarah($id)
    {
        $this->selectedMualafId = $id;
        $this->selectedMualaf = Mualaf::findOrFail($id);
        $this->tarikh_ziarah = now()->format('Y-m-d');
        $this->tujuan = '';
        $this->nota_hasil_ziarah = '';
        $this->isModalOpen = true;
    }

    public function closeLogZiarah()
    {
        $this->isModalOpen = false;
        $this->selectedMualafId = null;
        $this->selectedMualaf = null;
    }

    public function simpanLog()
    {
        $this->validate([
            'tarikh_ziarah' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'nota_hasil_ziarah' => 'nullable|string'
        ]);

        ZiarahLog::create([
            'mualaf_id' => $this->selectedMualafId,
            'user_id' => auth()->id(),
            'tarikh_ziarah' => $this->tarikh_ziarah,
            'tujuan' => $this->tujuan,
            'nota_hasil_ziarah' => $this->nota_hasil_ziarah,
        ]);

        session()->flash('message', 'Rekod log ziarah berjaya disimpan!');
        $this->tujuan = '';
        $this->nota_hasil_ziarah = '';
        $this->tarikh_ziarah = now()->format('Y-m-d');
    }
}
