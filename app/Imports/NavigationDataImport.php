<?php

namespace App\Imports;

use App\Models\NavigationHistory;
use App\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class NavigationDataImport implements ToModel, WithHeadingRow, WithValidation
{
    private $rowCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;

        // Vérifier que l'admin existe
        $admin = Admin::find($row['admin_id']);
        if (!$admin) {
            return null;
        }

        return new NavigationHistory([
            'admin_id' => $row['admin_id'],
            'page_name' => $row['page_name'],
            'page_url' => $row['page_url'],
            'visited_at' => Carbon::parse($row['visited_at']),
            'time_spent' => $row['time_spent'],
            'ip_address' => request()->ip(),
            'user_agent' => 'Import Excel',
            'session_id' => 'import_' . now()->timestamp
        ]);
    }

    public function rules(): array
    {
        return [
            'admin_id' => 'required|exists:admins,id',
            'page_name' => 'required|string|max:255',
            'page_url' => 'required|string|max:500',
            'visited_at' => 'required|date',
            'time_spent' => 'required|integer|min:0'
        ];
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}