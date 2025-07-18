<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('checklists')->insert([
            ['item' => 'Kod ikut PSR standard (naming)', 'is_required' => true],
            ['item' => '.env tidak mengandungi hardcoded credentials', 'is_required' => true],
            ['item' => 'Ada migration untuk perubahan DB', 'is_required' => false],
            ['item' => 'Ada unit test (jika sesuai)', 'is_required' => false],
        ]);
    }
}
