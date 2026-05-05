<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'NEW-MAKLUMAT-SAUDARA-KITA-2023.xls';

try {
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getSheetByName('DATA SAUDARA KITA');
    $rows = $sheet->toArray();
    for ($i = 100; $i < 110; $i++) {
        echo "Row " . ($i+1) . ": " . json_encode($rows[$i]) . "\n";
    }

    echo "Total Rows: " . count($rows) . "\n";
    echo "Row 1: " . json_encode($rows[0]) . "\n";
    echo "Row 2: " . json_encode($rows[1]) . "\n";
    echo "Row 3: " . json_encode($rows[2]) . "\n";
    echo "Row 4: " . json_encode($rows[3]) . "\n";
    echo "Row 5: " . json_encode($rows[4]) . "\n";
    echo "Row 6: " . json_encode($rows[5]) . "\n";
    echo "Row 7: " . json_encode($rows[6]) . "\n";
    
    $ic_count = 0;
    $duplicates = 0;
    $ics = [];
    
    foreach ($rows as $index => $row) {
        if ($index < 2) continue; // Skip title and header (assuming heading at 2)
        
        // Let's guess where IC is based on Row 2
        // Assuming Row 2 headers are: NO | NAMA | IC | ...
        // We'll just look for a 12-digit string or similar
        foreach($row as $cell) {
            if (is_string($cell)) {
                $clean = str_replace(['-', ' '], '', $cell);
                if (preg_match('/^\d{12}$/', $clean)) {
                    if (in_array($clean, $ics)) {
                        $duplicates++;
                    } else {
                        $ics[] = $clean;
                        $ic_count++;
                    }
                    break;
                }
            }
        }
    }
    
    echo "Unique ICs found (after Row 2): " . $ic_count . "\n";
    echo "Duplicate ICs found: " . $duplicates . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
