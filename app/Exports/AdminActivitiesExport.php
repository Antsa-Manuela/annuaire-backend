<?php

namespace App\Exports;

use App\Models\NavigationHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminActivitiesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = NavigationHistory::with('admin');

        if (isset($this->filters['admin_id']) && $this->filters['admin_id'] !== 'all') {
            $query->where('admin_id', $this->filters['admin_id']);
        }

        if (isset($this->filters['date_from']) && !empty($this->filters['date_from'])) {
            $query->where('visited_at', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to']) && !empty($this->filters['date_to'])) {
            $query->where('visited_at', '<=', $this->filters['date_to'] . ' 23:59:59');
        }

        return $query->orderBy('visited_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Administrateur',
            'Rôle',
            'Page',
            'URL',
            'Date de visite',
            'Temps passé (secondes)',
            'Adresse IP',
            'Agent utilisateur'
        ];
    }

    public function map($activity): array
    {
        return [
            $activity->id,
            $activity->admin->name,
            $activity->admin->role === 'super_admin' ? 'Super Admin' : 'Admin',
            $activity->page_name,
            $activity->page_url,
            $activity->visited_at->format('d/m/Y H:i:s'),
            $activity->time_spent,
            $activity->ip_address,
            $activity->user_agent
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour l'en-tête
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3498DB']]
            ],
            // Style alterné pour les lignes
            'A2:Z1000' => [
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F8F9FA']
                ]
            ],
        ];
    }
}