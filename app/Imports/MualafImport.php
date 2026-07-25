<?php

namespace App\Imports;

use App\Models\Mualaf;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class MualafImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 1; // Start from very top and handle row-by-row
    }

    public function model(array $row)
    {
        // 1. Ekstrak No IC (Utamakan index 3)
        $raw_ic = $row[3] ?? null;
        if (!$this->isValidIC($raw_ic)) {
            foreach ($row as $index => $cell) {
                if ($index == 1 || $index == 2) continue;
                if ($this->isValidIC($cell)) { $raw_ic = $cell; break; }
            }
        }
        $no_ic = $raw_ic ? trim(preg_replace('/[^a-zA-Z0-9]/', '', $raw_ic)) : null;
        if (empty($no_ic) || strlen($no_ic) < 5) return null;

        // 2. Nama Penuh (Islam) - index 2
        $nama_islam = $row[2] ?? null;
        if (empty($nama_islam) || strtoupper(trim($nama_islam)) == 'NAMA ISLAM') return null;

        // 3. Tarikh syahadah (index 10 atau 7)
        $tarikh_syahadah = $this->parseDate($row[10] ?? $row[7] ?? null);

        // 4. Gabungkan lokasi (index 7, 8, 9)
        $negeri = trim($row[7] ?? '');
        $nama_daerah_excel = trim($row[8] ?? '');
        $tempat = trim($row[9] ?? '');
        $tempat_syahadah = trim(implode(' - ', array_filter([$negeri, $nama_daerah_excel, $tempat])));

        // 5. Cari daerah_id
        $daerah_id = auth()->user()->daerah_id ?? null;
        if (!empty($nama_daerah_excel)) {
            $daerah = \App\Models\Daerah::where('nama_daerah', 'like', '%' . $nama_daerah_excel . '%')->first();
            if ($daerah) $daerah_id = $daerah->id;
        }

        // 6. UMUR (index 12) -> anggaran tarikh_lahir
        $tarikh_lahir = null;
        $umurRaw = $row[12] ?? null;
        if (is_numeric($umurRaw)) {
            $umur = (int) $umurRaw;
            if ($umur > 0 && $umur < 120) {
                $refYear = $tarikh_syahadah ? (int) substr($tarikh_syahadah, 0, 4) : now()->year;
                $tarikh_lahir = ($refYear - $umur) . '-01-01';
            }
        }

        // 7. Susun data
        $data = [
            'nama_penuh'         => trim($nama_islam),
            'nama_asal'          => trim($row[1] ?? ''),
            'jantina'            => trim($row[11] ?? ''),
            'bangsa_asal'        => trim($row[5] ?? ''),
            'tarikh_lahir'       => $tarikh_lahir,
            'no_telefon'         => trim($row[16] ?? ''),
            'pekerjaan'          => trim($row[6] ?? ''),
            'status_perkahwinan' => trim($row[13] ?? ''),
            'bil_anak'           => is_numeric($row[14] ?? null) ? (int) $row[14] : 0,
            'tarikh_syahadah'    => $tarikh_syahadah,
            'tempat_syahadah'    => $tempat_syahadah,
            'daerah_id'          => $daerah_id,
            'alamat_terkini'     => trim($row[4] ?? ''),
            'status_kematian'    => (isset($row[15]) && (str_contains(strtolower((string) $row[15]), 'meninggal') || $row[15] === true)) ? 1 : 0,
        ];

        // Buang nilai kosong ('' atau null) supaya tidak menimpa data sedia ada semasa UPDATE.
        // Nota: 0 (cth bil_anak, status_kematian) DIKEKALKAN.
        $data = array_filter($data, fn($v) => $v !== '' && $v !== null);

        // Upsert ikut no_ic. is_aktif TIDAK disentuh (kekal status lost-contact sedia ada).
        Mualaf::updateOrCreate(['no_ic' => $no_ic], $data);

        return null; // upsert dibuat manual, jangan biar ToModel insert semula
    }

    private function isValidIC($value)
    {
        if (empty($value)) return false;
        
        // Bersihkan semua simbol kecuali alphanumeric
        $clean = trim(preg_replace('/[^a-zA-Z0-9]/', '', $value));
        
        if (strlen($clean) < 5) return false;

        // 1. Format IC Malaysia (12 digit)
        if (preg_match('/^\d{12}$/', $clean)) {
            return true;
        }

        // 2. Format Passport / ID Tentera / ID Lain (Alphanumeric)
        // Mesti ada sekurang-kurangnya 1 huruf DAN 1 nombor untuk elakkan tersalah ambil data lain
        // ATAU ia mestilah di kolum yang betul (index 3) - tapi di sini kita check value sahaja
        if (preg_match('/[a-zA-Z]/', $clean) && preg_match('/\d/', $clean)) {
            return true;
        }

        // Jika ia hanya nombor tetapi bukan 12 digit, ia mungkin IC lama atau ID lain 
        // Elakkan nombor pendek (bawah 6 digit) yang mungkin kod atau tarikh excel
        if (ctype_digit($clean) && strlen($clean) >= 7) {
            return true;
        }

        return false;
    }

    private function parseDate($value)
    {
        if (empty($value)) return null;
        try {
            $cleanDate = str_replace(['O', 'o'], '0', $value);
            $date = Carbon::parse($cleanDate);
            
            // Semak jika tahun tidak masuk akal (Cth: 4711 atau 2106)
            $year = $date->year;
            if ($year < 1900 || $year > 2100) {
                return null;
            }

            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
