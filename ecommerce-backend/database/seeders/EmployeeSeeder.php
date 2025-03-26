<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EmployeeSeeder extends Seeder {
    public function run() {
        $employees = [
            [
                'name' => 'Ken Lorica',
                'email' => 'ken.lorica@gmail.com',
                'password' => Hash::make('Lorica123'),
                'role' => 'employee'
            ],
            [
                'name' => 'Joanna Lumogda',
                'email' => 'joanna.lumogda@gmail.com',
                'password' => Hash::make('Lumogda123'),
                'role' => 'employee'
            ],
            [
                'name' => 'Kerwin Macasunod',
                'email' => 'kerwin.macasunod@gmail.com',
                'password' => Hash::make('Macasunod123'),
                'role' => 'employee'
            ],
            [
                'name' => 'Mayen Mendoza',
                'email' => 'mayen.mendoza@gmail.com',
                'password' => Hash::make('Mendoza123'),
                'role' => 'employee'
            ],
            [
                'name' => 'Kian Miranda',
                'email' => 'kian.miranda@gmail.com',
                'password' => Hash::make('Miranda123'),
                'role' => 'employee'
            ]
        ];

        foreach ($employees as $employee) {
            User::create($employee);
        }
    }
}
