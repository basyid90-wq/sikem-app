<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kariah;

class KariahManager extends Component
{
    use WithPagination;

    // Form fields
    public $kariahId;
    public $nama_kariah;
    public $zon_daerah;
    public $alamat;
    public $nama_ajk;
    public $no_telefon;

    // Modals & States
    public $isFormOpen = false;
    public $search = '';

    protected $rules = [
        'nama_kariah' => 'required|string|max:255',
        'zon_daerah' => 'required|string|max:255',
        'alamat' => 'nullable|string',
        'nama_ajk' => 'nullable|string|max:255',
        'no_telefon' => 'nullable|string|max:50',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->reset(['nama_kariah', 'zon_daerah', 'alamat', 'nama_ajk', 'no_telefon']);
        $this->kariahId = $id;

        if ($id) {
            $kariah = Kariah::findOrFail($id);
            $this->nama_kariah = $kariah->nama_kariah;
            $this->zon_daerah = $kariah->zon_daerah;
            $this->alamat = $kariah->alamat;
            $this->nama_ajk = $kariah->nama_ajk;
            $this->no_telefon = $kariah->no_telefon;
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

        if ($this->kariahId) {
            $kariah = Kariah::findOrFail($this->kariahId);
            $kariah->update([
                'nama_kariah' => $this->nama_kariah,
                'zon_daerah' => $this->zon_daerah,
                'alamat' => $this->alamat,
                'nama_ajk' => $this->nama_ajk,
                'no_telefon' => $this->no_telefon,
            ]);
            session()->flash('message', 'Maklumat kariah berjaya dikemaskini!');
        } else {
            Kariah::create([
                'nama_kariah' => $this->nama_kariah,
                'zon_daerah' => $this->zon_daerah,
                'alamat' => $this->alamat,
                'nama_ajk' => $this->nama_ajk,
                'no_telefon' => $this->no_telefon,
            ]);
            session()->flash('message', 'Kariah baru berjaya ditambah!');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        Kariah::findOrFail($id)->delete();
        session()->flash('message', 'Kariah berjaya dipadam!');
    }

    public function render()
    {
        $kariahs = Kariah::where('nama_kariah', 'like', '%' . $this->search . '%')
            ->orWhere('zon_daerah', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.kariah-manager', [
            'kariahs' => $kariahs
        ]);
    }
}
