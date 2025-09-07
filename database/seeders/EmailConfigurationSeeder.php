<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailConfiguration;

class EmailConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed default email configurations
        EmailConfiguration::seedDefaults();
        
        $this->command->info('Email configurations seeded successfully!');
    }
}
