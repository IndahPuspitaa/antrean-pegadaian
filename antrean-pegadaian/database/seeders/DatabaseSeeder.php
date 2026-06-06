<?php

namespace Database\Seeders;

use App\Models\User;       
use App\Models\Counter;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Layanan (Sudah Direvisi)
        $categories = [
            [
                'name' => 'Cicilan', 
                'description' => 'Pembayaran cicilan gadai', 
                'estimated_time' => 5, 
                'sort_order' => 1
            ],
            [
                'name' => 'Perpanjang', 
                'description' => 'Perpanjangan masa gadai', 
                'estimated_time' => 5, 
                'sort_order' => 2
            ],
            [
                'name' => 'Tabungan', 
                'description' => 'Transaksi tabungan emas', 
                'estimated_time' => 5, 
                'sort_order' => 3
            ],
            [
                'name' => 'Pelunasan',
                'description' => 'Pelunasan barang gadai', 
                'estimated_time' => 5, 
                'sort_order' => 4
            ],
        ];

        foreach ($categories as $cat) {
            ServiceCategory::create($cat);
        }

        // 2. Data Loket Aktif
        Counter::create(['name' => 'Loket 1', 'is_active' => true]);
        Counter::create(['name' => 'Loket 2', 'is_active' => true]);

        // 3. Akun Otorisasi untuk Tablet Kiosk Depan
        User::create([
            'name' => 'Tablet Kiosk Depan',
            'username' => 'kiosk_depan',         
            'email' => 'kiosk@pegadaian.com',
            'password' => Hash::make('kiosk123'), 
            'role' => 'kiosk',
        ]);

        // 4. Akun Otorisasi untuk Kasir / Admin
        User::create([
            'name' => 'Admin Kasir',
            'username' => 'admin_kasir',        
            'email' => 'kasir@pegadaian.com',
            'password' => Hash::make('password'), 
            'role' => 'kasir',
        ]);
    }
}