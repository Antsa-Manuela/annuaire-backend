<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fonctionnaire;
use App\Models\HistoriquePersonnel;

class FonctionnaireSeeder extends Seeder
{
    public function run(): void
    {
        $fonctionnaires = [
            [
                'cin' => 'EMP001',
                'nom_complet' => 'Jean Dupont',
                'poste' => 'Enseignant',
                'contact' => '+261 34 12 345 67',
                'email' => 'jean.dupont@education.mg',
                'etablissement' => 'Lycée National',
                'actif' => true,
            ],
            [
                'cin' => 'EMP002',
                'nom_complet' => 'Marie Lambert',
                'poste' => 'RH',
                'contact' => '+261 33 12 345 67',
                'email' => 'marie.lambert@education.mg',
                'etablissement' => 'Ministère Education',
                'actif' => true,
            ]
        ];

        foreach ($fonctionnaires as $data) {
            $fonctionnaire = Fonctionnaire::create($data);

            HistoriquePersonnel::create([
                'fonctionnaire_id' => $fonctionnaire->id,
                'evenement' => 'Embauche',
                'details' => 'Recrutement initial',
                'date_evenement' => now()->subYears(2),
            ]);
        }

        $this->command->info('Fonctionnaires de démo créés avec succès!');
    }
}