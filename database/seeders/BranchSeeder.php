<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            [
                'name' => 'Main Branch',
                'address' => '123 Main Street',
                'city' => 'City A',
                'state' => 'State A',
                'owner_id' => 1, // Replace with a valid user ID
                'created_at' => Carbon::now()->subMonths(6), // 6 months ago
                'updated_at' => Carbon::now()->subMonths(6),
            ],
            [
                'name' => 'Secondary Branch',
                'address' => '456 Elm Street',
                'city' => 'City B',
                'state' => 'State B',
                'owner_id' => 2, // Replace with a valid user ID
                'created_at' => Carbon::now()->subMonths(5), // 5 months ago
                'updated_at' => Carbon::now()->subMonths(5),
            ],
            [
                'name' => 'Tertiary Branch',
                'address' => '789 Pine Avenue',
                'city' => 'City C',
                'state' => 'State C',
                'owner_id' => 1, // Replace with a valid user ID
                'created_at' => Carbon::now()->subMonths(3), // 3 months ago
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'New Branch',
                'address' => '101 Maple Road',
                'city' => 'City D',
                'state' => 'State D',
                'owner_id' => 2, // Replace with a valid user ID
                'created_at' => Carbon::now()->subMonths(1), // 1 month ago
                'updated_at' => Carbon::now()->subMonths(1),
            ],
            [
                'name' => 'New BranchY',
                'address' => '101 Maple RoadY',
                'city' => 'City DY',
                'state' => 'State DY',
                'owner_id' => 2, // Replace with a valid user ID
                'created_at' => Carbon::now()->subMonths(6), // 1 month ago
                'updated_at' => Carbon::now()->subMonths(6),
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
