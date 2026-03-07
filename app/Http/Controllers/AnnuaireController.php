<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AnnuaireController extends Controller
{
    // Lecture du fichier Excel
    private function readExcel()
    {
        $filePath = storage_path('app/etablissements.xlsx');

        if (!file_exists($filePath)) {
            abort(404, 'Fichier Excel non trouvé.');
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $data = [];
        $header = [];

        foreach ($sheet->getRowIterator() as $index => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            if ($index == 1) {
                $header = $rowData;
            } else {
                $data[] = array_combine($header, $rowData);
            }
        }

        return $data;
    }

    // Liste des établissements
    public function index()
    {
        $etablissements = $this->readExcel();
        return view('etablissements.index', compact('etablissements'));
    }

    // Détail d’un établissement
    public function show($id)
    {
        $etablissements = $this->readExcel();
        $etablissement = $etablissements[$id - 1] ?? null;

        if (!$etablissement) {
            abort(404, 'Établissement non trouvé.');
        }

        return view('etablissements.show', compact('etablissement', 'id'));
    }
}
