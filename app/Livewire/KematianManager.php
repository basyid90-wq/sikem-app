<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Kematian;
use App\Models\Mualaf;
use App\Models\User;
use App\Models\Kariah;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KematianManager extends Component
{
    use WithPagination, WithFileUploads;

    // Form fields
    public $kematianId;
    public $mualaf_id;
    public $pelapor_id;
    public $tarikh_mati;
    public $lokasi_mati;
    public $status_tuntutan_non = false;
    public $status_kes = 'baru';
    public $nota_log;
    public $polis_report; // For file upload
    public $polis_report_path;
    public $surat_wakil_path;
    public $kariah_dimaklumkan = false;

    // Search filter
    public $search = '';

    // Modals
    public $isFormOpen = false;

    protected $rules = [
        'mualaf_id' => 'required|exists:mualafs,id',
        'tarikh_mati' => 'required|date',
        'lokasi_mati' => 'required|string|max:255',
        'status_tuntutan_non' => 'boolean',
        'status_kes' => 'required|in:baru,dalam_proses,selesai',
        'nota_log' => 'nullable|string',
        'polis_report' => 'nullable|file|mimes:pdf,jpg,png|max:4096',
    ];

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->reset(['mualaf_id', 'pelapor_id', 'tarikh_mati', 'lokasi_mati', 'status_tuntutan_non', 'status_kes', 'nota_log', 'polis_report', 'polis_report_path', 'surat_wakil_path', 'kariah_dimaklumkan']);
        $this->kematianId = $id;

        if ($id) {
            $kematian = Kematian::findOrFail($id);
            $this->mualaf_id = $kematian->mualaf_id;
            $this->pelapor_id = $kematian->pelapor_id;
            $this->tarikh_mati = $kematian->tarikh_mati ? $kematian->tarikh_mati->format('Y-m-d') : null;
            $this->lokasi_mati = $kematian->lokasi_mati;
            $this->status_tuntutan_non = (bool) $kematian->status_tuntutan_non;
            $this->status_kes = $kematian->status_kes;
            $this->nota_log = $kematian->nota_log;
            $this->polis_report_path = $kematian->polis_report_path;
            $this->surat_wakil_path = $kematian->surat_wakil_path;
            $this->kariah_dimaklumkan = (bool) $kematian->kariah_dimaklumkan;
        } else {
            $this->pelapor_id = Auth::id();
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
            'mualaf_id' => $this->mualaf_id,
            'pelapor_id' => $this->pelapor_id ?: Auth::id(),
            'tarikh_mati' => $this->tarikh_mati,
            'lokasi_mati' => $this->lokasi_mati,
            'status_tuntutan_non' => $this->status_tuntutan_non,
            'status_kes' => $this->status_kes,
            'nota_log' => $this->nota_log,
        ];

        // Handle police report upload
        if ($this->polis_report) {
            $path = $this->polis_report->store('polis_reports', 'public');
            $data['polis_report_path'] = $path;
        }

        if ($this->kematianId) {
            Kematian::findOrFail($this->kematianId)->update($data);
            session()->flash('message', 'Laporan kematian berjaya dikemaskini!');
        } else {
            Kematian::create($data);
            session()->flash('message', 'Laporan kes kematian baru berjaya dibuat!');
        }

        $this->closeForm();
    }

    public function generateLetter($id)
    {
        $kematian = Kematian::with(['mualaf.kariah', 'pelapor'])->findOrFail($id);
        
        $pdfData = [
            'nama_mualaf' => $kematian->mualaf->nama_penuh,
            'no_ic' => $kematian->mualaf->no_ic,
            'tarikh_mati' => $kematian->tarikh_mati ? $kematian->tarikh_mati->format('d/m/Y') : '-',
            'lokasi_mati' => $kematian->lokasi_mati,
            'nama_kariah' => $kematian->mualaf->kariah ? $kematian->mualaf->kariah->nama_kariah : '-',
            'tarikh_surat' => now()->format('d/m/Y'),
        ];

        $html = "
        <h2 style='text-align:center;'>SURAT KUASA WAKIL PEJABAT AGAMA</h2>
        <p>Dengan hormatnya dimaklumkan bahawa penama di bawah adalah beragama Islam dan telah meninggal dunia:</p>
        <table style='width:100%; border:0;'>
            <tr><td style='width:30%; font-weight:bold;'>Nama Mualaf:</td><td>{$pdfData['nama_mualaf']}</td></tr>
            <tr><td style='font-weight:bold;'>No. IC:</td><td>{$pdfData['no_ic']}</td></tr>
            <tr><td style='font-weight:bold;'>Tarikh Kematian:</td><td>{$pdfData['tarikh_mati']}</td></tr>
            <tr><td style='font-weight:bold;'>Lokasi Kematian:</td><td>{$pdfData['lokasi_mati']}</td></tr>
            <tr><td style='font-weight:bold;'>Kariah Berdaftar:</td><td>{$pdfData['nama_kariah']}</td></tr>
        </table>
        <p style='margin-top:20px;'>Pihak Pejabat Agama Islam dengan ini memberi pelepasan dan kebenaran untuk pengurusan jenazah di hospital / rumah mengikut syariat Islam.</p>
        <br/><br/>
        <p>Tarikh Surat: {$pdfData['tarikh_surat']}</p>
        <p><strong>Pejabat Agama Islam Daerah</strong></p>
        ";

        $pdf = Pdf::loadHTML($html);
        $fileName = 'surat_wakil_' . $id . '.pdf';
        
        // Save pdf to public storage folder for easy previewing
        $filePath = 'surat_wakil/' . $fileName;
        Storage::disk('public')->put($filePath, $pdf->output());

        $kematian->update(['surat_wakil_path' => $filePath]);
        $this->surat_wakil_path = $filePath;

        session()->flash('message', 'Surat kuasa wakil berjaya dijana!');
        if ($this->isFormOpen) {
            $this->openForm($id);
        }
    }

    public function getWhatsappLink($id)
    {
        $kematian = Kematian::with(['mualaf.kariah'])->findOrFail($id);
        if (!$kematian->mualaf || !$kematian->mualaf->kariah) {
            return '#';
        }

        $kariah = $kematian->mualaf->kariah;
        $tel = preg_replace('/[^0-9]/', '', $kariah->no_telefon ?: '');
        if (!$tel) {
            return '#';
        }

        // Add 60 prefix for Malaysia if needed
        if (substr($tel, 0, 1) === '1') {
            $tel = '60' . $tel;
        }

        $msg = "Assalamualaikum AJK Kariah {$kariah->nama_kariah}. " .
               "Dimaklumkan bahawa mualaf {$kematian->mualaf->nama_penuh} " .
               "telah meninggal dunia pada {$kematian->tarikh_mati->format('d/m/Y')} " .
               "di {$kematian->lokasi_mati}. " .
               "Mohon tindakan lanjut pengurusan jenazah dari pihak Kariah. Terima kasih.";

        $link = "https://wa.me/{$tel}?text=" . urlencode($msg);

        // Also mark as kariah informed
        $kematian->update(['kariah_dimaklumkan' => true]);
        $this->kariah_dimaklumkan = true;

        return $link;
    }

    public function delete($id)
    {
        Kematian::findOrFail($id)->delete();
        session()->flash('message', 'Kes kematian berjaya dipadam!');
    }

    public function render()
    {
        $kematians = Kematian::with(['mualaf', 'pelapor'])
            ->whereHas('mualaf', function($q) {
                $q->where('nama_penuh', 'like', '%' . $this->search . '%')
                  ->orWhere('no_ic', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.kematian-manager', [
            'kematians' => $kematians,
            'mualafs' => Mualaf::orderBy('nama_penuh')->get()
        ]);
    }
}
