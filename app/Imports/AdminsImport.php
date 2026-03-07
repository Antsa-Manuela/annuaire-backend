<?php

namespace App\Imports;

use App\Models\Admin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Admin([
            'cin' => $row['cin'],       // correspond à la colonne CIN dans Excel
            'email' => $row['email'],   // correspond à la colonne Email
            'password' => bcrypt($row['password']), // mot de passe chiffré
            'is_active' => $row['is_active'] ?? true,
        ]);
    }
}
