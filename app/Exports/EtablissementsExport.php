<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EtablissementsExport implements \Maatwebsite\Excel\Concerns\FromArray
{
    public function array(): array
    {
        $path = storage_path('app/etablissements.xlsx');

        if (!file_exists($path)) return [];

        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();

        $rows = $worksheet->toArray();
        return $rows;
    }
}
