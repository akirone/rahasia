<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'] ?? $row['nama'],
            'email' => $row['email'],
            'nis' => $row['nis'] ?? $row['nisn'],
            'kelas' => $row['kelas'],
            'password' => Hash::make($row['password'] ?? '12345678'),
            'is_admin' => false,
        ]);
    }
}
