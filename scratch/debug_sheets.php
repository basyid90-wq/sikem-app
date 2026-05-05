<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
$file = 'NEW-MAKLUMAT-SAUDARA-KITA-2023.xls';
$spreadsheet = IOFactory::load($file);
foreach ($spreadsheet->getSheetNames() as $name) {
    $sheet = $spreadsheet->getSheetByName($name);
    $rows = $sheet->toArray();
    echo "Sheet: $name | Total Rows: " . count($rows) . "\n";
    foreach ($rows as $i => $r) {
        if ($i > 5) break;
        echo "  Row " . ($i+1) . ": " . json_encode($r) . "\n";
    }
}
