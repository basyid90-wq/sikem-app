<?php

namespace App\Imports;

use App\Models\Mualaf;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class MualafImport implements ToModel, WithStartRow, WithMultipleSheets, SkipsEmptyRows
{
    public function sheets(): array
    {
        return [
            0 => $this,
            1 => $this,
            2 => $this,
            3 => $this,
        ];
    }

    public function startRow(): int
    {
        return 1; // Start from very top and handle row-by-row
    }

    public function model(array $row)
    {
        // 1. Ekstrak No IC (Utamakan index 3)
        $raw_ic = $row[3] ?? null;
        
        // Hanya cari di kolum lain jika index 3 kosong/tidak sah
        if (!$this->isValidIC($raw_ic)) {
            foreach ($row as $index => $cell) {
                // Jangan cari di kolum Nama (index 1 & 2)
                if ($index == 1 || $index == 2) continue;
                
                if ($this->isValidIC($cell)) {
                    $raw_ic = $cell;
                    break;
                }
            }
        }

        $no_ic = $raw_ic ? trim(preg_replace('/[^a-zA-Z0-9]/', '', $raw_ic)) : null;

        // Jika tiada IC yang sah, abaikan
        if (empty($no_ic) || strlen($no_ic) < 5) {
            return null;
        }

        // 2. Semak kewujudan No IC
        if (Mualaf::where('no_ic', $no_ic)->exists()) {
            return null; // skip duplicate
        }

        // 3. Nama Penuh (Islam) - Biasanya index 2
        $nama_islam = $row[2] ?? null;
        if (empty($nama_islam) || strtoupper($nama_islam) == 'NAMA ISLAM') return null;

        // 4. Bersihkan Tarikh (Index 10 atau 7)
        $tarikh_syahadah = $this->parseDate($row[10] ?? $row[7] ?? null);

        // 5. Gabungkan lokasi (Index 7, 8, 9)
        $negeri = trim($row[7] ?? '');
        $nama_daerah_excel = trim($row[8] ?? '');
        $tempat = trim($row[9] ?? '');
        $tempat_syahadah = trim(implode(' - ', array_filter([$negeri, $nama_daerah_excel, $tempat])));

        // 6. Cari daerah_id berdasarkan nama daerah dalam excel
        $daerah_id = auth()->user()->daerah_id ?? null;
        if (!empty($nama_daerah_excel)) {
            $daerah = \App\Models\Daerah::where('nama_daerah', 'like', '%' . $nama_daerah_excel . '%')->first();
            if ($daerah) {
                $daerah_id = $daerah->id;
            }
        }

        return new Mualaf([
            'no_ic'              => $no_ic,
            'nama_penuh'         => trim($nama_islam),
            'nama_asal'          => trim($row[1] ?? ''),
            'jantina'            => trim($row[11] ?? ($row[9] == 'L' || $row[9] == 'P' ? $row[9] : '')),
            'bangsa_asal'        => trim($row[5] ?? ''),
            'tarikh_lahir'       => $this->parseDate($row[12] ?? null),
            'no_telefon'         => trim($row[16] ?? $row[14] ?? ''),
            'pekerjaan'          => trim($row[6] ?? ''),
            'status_perkahwinan' => trim($row[13] ?? ''),
            'bil_anak'           => is_numeric($row[14] ?? null) ? (int)$row[14] : 0,
            'tarikh_syahadah'    => $tarikh_syahadah,
            'tempat_syahadah'    => $tempat_syahadah,
            'daerah_id'          => $daerah_id,
            'kariah_id'          => null,
            'alamat_terkini'     => trim($row[4] ?? ''),
            'status_kematian'    => (isset($row[15]) && (str_contains(strtolower($row[15]), 'meninggal') || $row[15] === true)) ? 1 : 0,
        ]);
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
