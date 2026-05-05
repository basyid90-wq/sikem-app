<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelasApim;
use App\Models\User;

class KelasApimManager extends Component
{
    use WithPagination;

    // Form fields
    public $kelasId;
    public $guru_id;
    public $tajuk_kelas;
    public $mod_kelas = 'fizikal';
    public $pautan_online;
    public $masa_mula;
    public $masa_tamat;
    public $status = 'aktif';

    // Modals & States
    public $isFormOpen = false;
    public $search = '';

    protected $rules = [
        'guru_id' => 'required|exists:users,id',
        'tajuk_kelas' => 'required|string|max:255',
        'mod_kelas' => 'required|in:fizikal,online',
        'pautan_online' => 'nullable|required_if:mod_kelas,online|string|max:255',
        'masa_mula' => 'required|date',
        'masa_tamat' => 'required|date|after:masa_mula',
        'status' => 'required|in:aktif,selesai,batal',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->reset(['guru_id', 'tajuk_kelas', 'mod_kelas', 'pautan_online', 'masa_mula', 'masa_tamat', 'status']);
        $this->kelasId = $id;

        if ($id) {
            $kelas = KelasApim::findOrFail($id);
            $this->guru_id = $kelas->guru_id;
            $this->tajuk_kelas = $kelas->tajuk_kelas;
            $this->mod_kelas = $kelas->mod_kelas;
            $this->pautan_online = $kelas->pautan_online;
            $this->masa_mula = $kelas->masa_mula->format('Y-m-d\TH:i');
            $this->masa_tamat = $kelas->masa_tamat->format('Y-m-d\TH:i');
            $this->status = $kelas->status;
        } else {
            // Pick default teacher if exists
            $this->guru_id = User::first()?->id;
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
            'guru_id' => $this->guru_id,
            'tajuk_kelas' => $this->tajuk_kelas,
            'mod_kelas' => $this->mod_kelas,
            'pautan_online' => $this->mod_kelas === 'online' ? $this->pautan_online : null,
            'masa_mula' => $this->masa_mula,
            'masa_tamat' => $this->masa_tamat,
            'status' => $this->status,
        ];

        if ($this->kelasId) {
            KelasApim::findOrFail($this->kelasId)->update($data);
            session()->flash('message', 'Maklumat kelas berjaya dikemaskini!');
        } else {
            KelasApim::create($data);
            session()->flash('message', 'Kelas baru berjaya dijadualkan!');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        KelasApim::findOrFail($id)->delete();
        session()->flash('message', 'Kelas berjaya dipadam!');
    }

    public function render()
    {
        $kelases = KelasApim::with('guru')
            ->where('tajuk_kelas', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.kelas-apim-manager', [
            'kelases' => $kelases,
            'gurus' => User::orderBy('name')->get()
        ]);
    }
}
