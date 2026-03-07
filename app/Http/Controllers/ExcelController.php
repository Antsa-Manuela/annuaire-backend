<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AdminActivitiesExport;
use App\Exports\NavigationHistoryExport;
use App\Exports\DashboardDataExport;
use App\Imports\NavigationDataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserActivity;

class ExcelController extends Controller
{
    /**
     * Exporter les activités des admins
     */
    public function exportAdminActivities(Request $request)
    {
        try {
            $filters = $request->all();
            
            // Logger l'activité d'export
            UserActivity::logActivity(
                auth()->id(),
                UserActivity::TYPE_EXPORT,
                'Export des activités administrateurs vers Excel',
                ['filters' => $filters]
            );

            return Excel::download(new AdminActivitiesExport($filters), 'activites_admins_' . now()->format('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'exportation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exporter l'historique de navigation
     */
    public function exportNavigationHistory(Request $request)
    {
        try {
            $filters = $request->all();

            // Logger l'activité d'export
            UserActivity::logActivity(
                auth()->id(),
                UserActivity::TYPE_EXPORT,
                'Export de l\'historique de navigation vers Excel',
                ['filters' => $filters]
            );

            return Excel::download(new NavigationHistoryExport($filters), 'historique_navigation_' . now()->format('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'exportation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exporter les données du dashboard
     */
    public function exportDashboardData(Request $request)
    {
        try {
            $filters = $request->all();

            // Logger l'activité d'export
            UserActivity::logActivity(
                auth()->id(),
                UserActivity::TYPE_EXPORT,
                'Export des données du dashboard vers Excel',
                ['filters' => $filters]
            );

            return Excel::download(new DashboardDataExport($filters), 'dashboard_data_' . now()->format('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'exportation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importer des données de navigation
     */
    public function importNavigationData(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls|max:10240' // 10MB max
            ]);

            // Logger le début de l'import
            UserActivity::logActivity(
                auth()->id(),
                UserActivity::TYPE_IMPORT,
                'Début de l\'importation de données navigation'
            );

            // Importer le fichier
            $import = new NavigationDataImport;
            Excel::import($import, $request->file('file'));

            // Logger la fin de l'import
            UserActivity::logActivity(
                auth()->id(),
                UserActivity::TYPE_IMPORT,
                'Importation de données navigation terminée',
                [
                    'rows_imported' => $import->getRowCount(),
                    'file_name' => $request->file('file')->getClientOriginalName()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Importation réussie !',
                'data' => [
                    'rows_imported' => $import->getRowCount(),
                    'file_name' => $request->file('file')->getClientOriginalName()
                ]
            ]);

        } catch (\Exception $e) {
            // Logger l'erreur d'import
            UserActivity::logActivity(
                auth()->id(),
                UserActivity::TYPE_IMPORT,
                'Erreur lors de l\'importation de données navigation',
                ['error' => $e->getMessage()]
            );

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'importation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Télécharger un template d'importation
     */
    public function downloadImportTemplate()
    {
        try {
            $templateData = [
                ['admin_id', 'page_name', 'page_url', 'visited_at', 'time_spent'],
                [1, 'Tableau de bord', '/dashboard', '2024-01-15 10:30:00', 120],
                [2, 'Liste des établissements', '/etablissements', '2024-01-15 11:00:00', 300]
            ];

            return Excel::download(new class($templateData) implements \Maatwebsite\Excel\Concerns\FromArray {
                private $data;

                public function __construct($data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return $this->data;
                }
            }, 'template_import_navigation.xlsx');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement du template',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}