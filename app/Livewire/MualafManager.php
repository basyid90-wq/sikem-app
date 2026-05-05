<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Mualaf;
use App\Models\Kariah;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MualafImport;
use Illuminate\Support\Facades\Storage;

class MualafManager extends Component
{
    use WithPagination, WithFileUploads;

    // Form fields
    public $mualafId;
    public $nama_penuh;
    public $no_ic;
    public $no_kad_mualaf;
    public $tarikh_syahadah;
    public $tempat_syahadah;
    public $kariah_id;
    public $status_khairat = false;
    public $status_kematian = false;
    public $alamat_terkini;
    public $nama_asal;
    public $jantina;
    public $bangsa_asal;
    public $tarikh_lahir;
    public $no_telefon;
    public $pekerjaan;
    public $status_perkahwinan;
    public $bil_anak = 0;
    public $waris_islam_nama;
    public $waris_islam_tel;
    public $waris_non_nama;
    public $waris_non_tel;

    // Files fields
    public $sijil_islam;
    public $kad_mualaf;

    // Import fields
    public $excel_file;

    // Modals & States
    public $isFormOpen = false;
    public $isImportOpen = false;
    public $isViewOpen = false;
    public $viewingMualaf = null;
    public $activeTab = 'aktif';
    public $search = '';

    protected function rules()
    {
        return [
            'nama_penuh' => 'required|string|max:255',
            'no_ic' => 'required|string|max:20|unique:mualafs,no_ic,' . $this->mualafId,
            'no_kad_mualaf' => 'nullable|string|max:50|unique:mualafs,no_kad_mualaf,' . $this->mualafId,
            'tarikh_syahadah' => 'nullable|date',
            'tempat_syahadah' => 'nullable|string',
            'kariah_id' => 'nullable|exists:kariahs,id',
            'status_khairat' => 'boolean',
            'status_kematian' => 'boolean',
            'alamat_terkini' => 'nullable|string',
            'nama_asal' => 'nullable|string|max:255',
            'jantina' => 'nullable|string|max:50',
            'bangsa_asal' => 'nullable|string|max:100',
            'tarikh_lahir' => 'nullable|date',
            'no_telefon' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:255',
            'status_perkahwinan' => 'nullable|string|max:50',
            'bil_anak' => 'nullable|integer|min:0',
            'waris_islam_nama' => 'nullable|string|max:255',
            'waris_islam_tel' => 'nullable|string|max:50',
            'waris_non_nama' => 'nullable|string|max:255',
            'waris_non_tel' => 'nullable|string|max:50',
            'sijil_islam' => 'nullable|file|max:10240', // Max 10MB
            'kad_mualaf' => 'nullable|file|max:10240',  // Max 10MB
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->reset([
            'nama_penuh', 'no_ic', 'no_kad_mualaf', 'tarikh_syahadah', 'kariah_id', 
            'nama_penuh', 'no_ic', 'no_kad_mualaf', 'tarikh_syahadah', 'tempat_syahadah', 'kariah_id', 
            'status_khairat', 'status_kematian', 'alamat_terkini', 'nama_asal', 'jantina', 'bangsa_asal', 
            'tarikh_lahir', 'no_telefon', 'pekerjaan', 'status_perkahwinan', 'bil_anak',
            'waris_islam_nama', 'waris_islam_tel', 'waris_non_nama', 'waris_non_tel', 'sijil_islam', 'kad_mualaf'
        ]);
        $this->mualafId = $id;

        if ($id) {
            $mualaf = Mualaf::findOrFail($id);
            $this->nama_penuh = $mualaf->nama_penuh;
            $this->no_ic = $mualaf->no_ic;
            $this->no_kad_mualaf = $mualaf->no_kad_mualaf;
            $this->tarikh_syahadah = $mualaf->tarikh_syahadah ? $mualaf->tarikh_syahadah->format('Y-m-d') : null;
            $this->tempat_syahadah = $mualaf->tempat_syahadah;
            $this->kariah_id = $mualaf->kariah_id;
            $this->status_khairat = (bool) $mualaf->status_khairat;
            $this->status_kematian = (bool) $mualaf->status_kematian;
            $this->alamat_terkini = $mualaf->alamat_terkini;
            $this->nama_asal = $mualaf->nama_asal;
            $this->jantina = $mualaf->jantina;
            $this->bangsa_asal = $mualaf->bangsa_asal;
            $this->tarikh_lahir = $mualaf->tarikh_lahir ? $mualaf->tarikh_lahir->format('Y-m-d') : null;
            $this->no_telefon = $mualaf->no_telefon;
            $this->pekerjaan = $mualaf->pekerjaan;
            $this->status_perkahwinan = $mualaf->status_perkahwinan;
            $this->bil_anak = $mualaf->bil_anak;
            $this->waris_islam_nama = $mualaf->waris_islam_nama;
            $this->waris_islam_tel = $mualaf->waris_islam_tel;
            $this->waris_non_nama = $mualaf->waris_non_nama;
            $this->waris_non_tel = $mualaf->waris_non_tel;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
    }

    public function openImport()
    {
        $this->reset(['excel_file']);
        $this->resetValidation();
        $this->isImportOpen = true;
    }

    public function closeImport()
    {
        $this->isImportOpen = false;
    }

    public function openView($id)
    {
        $this->viewingMualaf = Mualaf::with('kariah')->findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeView()
    {
        $this->isViewOpen = false;
        $this->viewingMualaf = null;
    }

    public function importExcel()
    {
        $this->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        Excel::import(new MualafImport, $this->excel_file->getRealPath());

        session()->flash('message', 'Data mualaf berjaya dimasukkan daripada fail Excel!');
        $this->closeImport();
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_penuh' => $this->nama_penuh,
            'no_ic' => $this->no_ic,
            'no_kad_mualaf' => $this->no_kad_mualaf,
            'tarikh_syahadah' => $this->tarikh_syahadah,
            'tempat_syahadah' => $this->tempat_syahadah,
            'kariah_id' => $this->kariah_id ?: null,
            'status_khairat' => (bool) $this->status_khairat,
            'status_kematian' => (bool) $this->status_kematian,
            'alamat_terkini' => $this->alamat_terkini,
            'nama_asal' => $this->nama_asal,
            'jantina' => $this->jantina,
            'bangsa_asal' => $this->bangsa_asal,
            'tarikh_lahir' => $this->tarikh_lahir,
            'no_telefon' => $this->no_telefon,
            'pekerjaan' => $this->pekerjaan,
            'status_perkahwinan' => $this->status_perkahwinan,
            'bil_anak' => (int) $this->bil_anak,
            'waris_islam_nama' => $this->waris_islam_nama,
            'waris_islam_tel' => $this->waris_islam_tel,
            'waris_non_nama' => $this->waris_non_nama,
            'waris_non_tel' => $this->waris_non_tel,
        ];

        if ($this->sijil_islam) {
            $data['sijil_islam_path'] = $this->sijil_islam->store('sijil_islam', 'public');
        }

        if ($this->kad_mualaf) {
            $data['kad_mualaf_path'] = $this->kad_mualaf->store('kad_mualaf', 'public');
        }

        if ($this->mualafId) {
            $mualaf = Mualaf::findOrFail($this->mualafId);
            $mualaf->update($data);
            session()->flash('message', 'Profil Mualaf berjaya dikemaskini!');
        } else {
            Mualaf::create($data);
            session()->flash('message', 'Mualaf baru berjaya didaftarkan!');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        Mualaf::findOrFail($id)->delete();
        session()->flash('message', 'Profil Mualaf berjaya dipadam!');
    }

    public function toggleStatusAktif($id)
    {
        $mualaf = Mualaf::findOrFail($id);
        $mualaf->is_aktif = !$mualaf->is_aktif;
        $mualaf->save();

        $status = $mualaf->is_aktif ? 'Aktif' : 'Lost Contact';
        session()->flash('message', "Status $mualaf->nama_penuh telah ditukar kepada $status.");
    }

    public function getDynamicTabsProperty()
    {
        $currentYear = now()->year;
        return range($currentYear, $currentYear - 4);
    }

    public function render()
    {
        // Base Query (Search + Global Scopes)
        $baseQuery = Mualaf::with('kariah')
            ->where(function($query) {
                $query->where('nama_penuh', 'like', '%' . $this->search . '%')
                      ->orWhere('no_ic', 'like', '%' . $this->search . '%');
            });

        // Metrik Statistik Dinamik (Berdasarkan Tahun jika dipilih)
        $statsQuery = clone $baseQuery;
        if (is_numeric($this->activeTab)) {
            $statsQuery->whereYear('tarikh_syahadah', $this->activeTab);
        }

        $countAktif = (clone $statsQuery)->where('is_aktif', true)->count();
        $countArkib = (clone $statsQuery)->where('is_aktif', false)->count();
        $countTotal = $countAktif + $countArkib;

        // Data Listing (Berdasarkan Tab Aktif)
        $query = clone $baseQuery;
        if ($this->activeTab === 'aktif') {
            $query->where('is_aktif', true);
        } elseif ($this->activeTab === 'arkib') {
            $query->where('is_aktif', false);
        } elseif (is_numeric($this->activeTab)) {
            $query->whereYear('tarikh_syahadah', $this->activeTab);
        }

        $mualafs = $query->paginate(15);

        return view('livewire.mualaf-manager', [
            'mualafs' => $mualafs,
            'kariahs' => Kariah::orderBy('nama_kariah')->get(),
            'totalAktif' => $countAktif,
            'totalArkib' => $countArkib,
            'totalSemua' => $countTotal
        ]);
    }
}
