<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EtablissementController extends Controller
{
    // Affichage de la liste des établissements
    public function index()
    {
        $etablissements = $this->readExcel(storage_path('app/etablissements.xlsx'));
        return view('etablissements.index', compact('etablissements'));
    }

    // Affichage du détail d’un établissement
    public function show($id)
    {
        $etablissements = $this->readExcel(storage_path('app/etablissements.xlsx'));
        $etablissement = collect($etablissements)->firstWhere('id', $id);

        if (!$etablissement) {
            abort(404, 'Établissement introuvable');
        }

        return view('etablissements.show', compact('etablissement'));
    }

    // Lecture Excel → tableau associatif
    private function readExcel($path)
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $headers = array_shift($rows);
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($headers, $row);
        }

        return $data;
    }
}
