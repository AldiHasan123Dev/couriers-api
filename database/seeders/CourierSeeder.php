<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        $namaDepan = [
            'Budi', 'Agung', 'Andi', 'Siti', 'Rizky',
            'Dewi', 'Fajar', 'Rina', 'Dimas', 'Agus',
            'Putri', 'Hendra', 'Maya', 'Eko', 'Wahyu',
            'Nanda', 'Arif', 'Lina', 'Yoga', 'Adi',
            'Rudi', 'Dian', 'Bayu', 'Rian', 'Tono',
        ];

        $namaBelakang = [
            'Santoso', 'Pratama', 'Wijaya', 'Rahmawati',
            'Firmansyah', 'Anggraini', 'Nugraha', 'Marlina',
            'Saputra', 'Setiawan', 'Lestari', 'Kurniawan',
            'Safitri', 'Prasetyo', 'Ramadhan', 'Permata',
            'Hidayat', 'Oktaviani', 'Kusuma', 'Maulana',
        ];

        $kota = [
            'Surabaya', 'Sidoarjo', 'Gresik', 'Malang',
            'Mojokerto', 'Pasuruan', 'Kediri', 'Jombang',
            'Lamongan', 'Bojonegoro', 'Madiun', 'Blitar',
            'Tuban', 'Banyuwangi', 'Jember', 'Probolinggo',
            'Lumajang', 'Bangkalan', 'Pamekasan', 'Sumenep',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $depan = $namaDepan[($i - 1) % count($namaDepan)];
            $belakang = $namaBelakang[($i - 1) % count($namaBelakang)];

            $nama = $depan . ' ' . $belakang . ' ' . $i;

            Courier::updateOrCreate(
                [
                    'email' => 'kurir' . $i . '@example.com',
                ],
                [
                    'name' => $nama,
                    'phone' => '0812' . str_pad(
                        (string) $i,
                        8,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'address' => $kota[($i - 1) % count($kota)]
                        . ', Jawa Timur',
                    'level' => (($i - 1) % 5) + 1,
                    'is_active' => $i % 4 !== 0,
                    'created_at' => now()->subDays($i),
                    'updated_at' => now(),
                ]
            );
        }
    }
}