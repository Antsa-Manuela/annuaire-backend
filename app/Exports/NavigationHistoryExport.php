<?php

namespace App\Exports;

use App\Models\NavigationHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class NavigationHistoryExport implements FromCollection, WithHeadings, WithMapping, WithTitle
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

        return $query->orderBy('visited_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'Admin ID',
            'Nom Admin',
            'Email Admin',
            'Page Visité',
            'URL',
            'Date Visite',
            'Heure Visite',
            'Temps Passé (s)',
            'IP'
        ];
    }

    public function map($history): array
    {
        return [
            $history->admin_id,
            $history->admin->name,
            $history->admin->email,
            $history->page_name,
            $history->page_url,
            $history->visited_at->format('d/m/Y'),
            $history->visited_at->format('H:i:s'),
            $history->time_spent,
            $history->ip_address
        ];
    }

    public function title(): string
    {
        return 'Historique Navigation';
    }
}