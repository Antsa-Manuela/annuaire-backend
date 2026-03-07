<?php
// app/Services/CsvImportService.php

namespace App\Services;

use App\Models\Etablissement;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class CsvImportService
{
    public function importEtablissements($filePath)
    {
        $csv = Reader::createFromPath(storage_path('app/' . $filePath), 'r');
        $csv->setHeaderOffset(0);
        
        $records = $csv->getRecords();
        $imported = 0;
        $errors = [];

        foreach ($records as $offset => $record) {
            try {
                $this->createOrUpdateEtablissement($record);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Ligne $offset: " . $e->getMessage();
            }
        }

        return [
            'imported' => $imported,
            'errors' => $errors
        ];
    }

    private function createOrUpdateEtablissement($data)
    {
        // Nettoyage et transformation des données
        $cleanedData = [
            'code_etab' => $data['code_etab'],
            'secteur' => $data['secteur'],
            'cisco' => $data['cisco'],
            'commune' => $data['commune'],
            'zap' => $data['zap'],
            'fokontany' => $data['fokontany'],
            'nom_etab' => $data['nom_etab'],
            'latitude' => $this->parseCoordinate($data['x']),
            'longitude' => $this->parseCoordinate($data['y']),
            'nb_ENF' => (int) $data['nb_ENF'],
            'nb_Ens_foncts' => (int) $data['nb_Ens_foncts'],
            'nb_PA_NonFonct' => (int) $data['nb_PA_NonFonct'],
            'nb_PA_Fonct' => (int) $data['nb_PA_Fonct'],
            'nb_Benevols' => (int) $data['nb_Benevoles'],
            'effectif_total_Personnels' => (int) $data['effectif_total_Personnels']
        ];

        Etablissement::updateOrCreate(
            ['code_etab' => $cleanedData['code_etab']],
            $cleanedData
        );
    }

    private function parseCoordinate($coord)
    {
        return is_numeric($coord) ? $coord : null;
    }
}