<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class TetapanSistem extends Component
{
    public $elaun_apim;
    public $pegawai_nama;
    public $pegawai_jawatan;
    public $whatsapp_api_key;
    public $whatsapp_instance_id;

    public function mount()
    {
        $this->elaun_apim = Setting::get('elaun_apim', '150.00');
        $this->pegawai_nama = Setting::get('pegawai_nama', '');
        $this->pegawai_jawatan = Setting::get('pegawai_jawatan', '');
        $this->whatsapp_api_key = Setting::get('whatsapp_api_key', '');
        $this->whatsapp_instance_id = Setting::get('whatsapp_instance_id', '');
    }

    public function simpanTetapan()
    {
        Setting::set('elaun_apim', $this->elaun_apim);
        Setting::set('pegawai_nama', $this->pegawai_nama);
        Setting::set('pegawai_jawatan', $this->pegawai_jawatan);
        Setting::set('whatsapp_api_key', $this->whatsapp_api_key);
        Setting::set('whatsapp_instance_id', $this->whatsapp_instance_id);

        session()->flash('message', 'Tetapan sistem telah berjaya disimpan!');
    }

    public function render()
    {
        return view('livewire.tetapan-sistem')->extends('layouts.app')->section('content');
    }
}
