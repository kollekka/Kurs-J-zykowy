<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'enrollment_id' => 3, // Zakładamy, że zapis o ID 1 istnieje
                'amount' => 199.99,
                'payment_date' => now(),
                'payment_method' => 'card',
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment_id' => 4, // Zakładamy, że zapis o ID 2 istnieje
                'amount' => 299.99,
                'payment_date' => now(),
                'payment_method' => 'paypal',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
    
}
