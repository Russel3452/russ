<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\Session;
use App\Models\Registration;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@wellness.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '555-0100',
            ]
        );

        // Create Coordinators
        $coordinator1 = User::firstOrCreate(
            ['email' => 'coordinator1@wellness.com'],
            [
                'name' => 'Sarah Johnson',
                'password' => Hash::make('password'),
                'role' => 'coordinator',
                'phone' => '555-0101',
            ]
        );

        $coordinator2 = User::firstOrCreate(
            ['email' => 'coordinator2@wellness.com'],
            [
                'name' => 'Michael Chen',
                'password' => Hash::make('password'),
                'role' => 'coordinator',
                'phone' => '555-0102',
            ]
        );

        // Create Participants with varied dates (last 6 months)
        $participants = [];
        for ($i = 1; $i <= 30; $i++) {
            // Create users across the last 6 months for chart data
            $createdDate = now()->subMonths(rand(0, 5))->subDays(rand(0, 30));
            
            $participant = User::firstOrCreate(
                ['email' => "participant$i@wellness.com"],
                [
                    'name' => "Participant $i",
                    'password' => Hash::make('password'),
                    'role' => 'participant',
                    'phone' => '555-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'date_of_birth' => now()->subYears(rand(20, 50)),
                    'gender' => ['male', 'female', 'other'][rand(0, 2)],
                ]
            );
            
            // Update created_at for chart variation
            $participant->created_at = $createdDate;
            $participant->save();
            
            $participants[] = $participant;
        }

        // Create Programs with varied dates for chart data
        $programs = [];
        $programData = [
            ['name' => 'Weight Loss Challenge', 'category' => 'Fitness', 'coordinator' => $coordinator1],
            ['name' => 'Stress Management Workshop', 'category' => 'Mental Health', 'coordinator' => $coordinator2],
            ['name' => 'Yoga and Meditation', 'category' => 'Wellness', 'coordinator' => $coordinator1],
            ['name' => 'Nutrition Basics', 'category' => 'Nutrition', 'coordinator' => $coordinator2],
            ['name' => 'Cardio Bootcamp', 'category' => 'Fitness', 'coordinator' => $coordinator1],
            ['name' => 'Mindfulness Training', 'category' => 'Mental Health', 'coordinator' => $coordinator2],
            ['name' => 'Strength Training', 'category' => 'Fitness', 'coordinator' => $coordinator1],
            ['name' => 'Healthy Cooking Class', 'category' => 'Nutrition', 'coordinator' => $coordinator2],
        ];

        foreach ($programData as $index => $data) {
            $createdDate = now()->subMonths(rand(0, 5))->subDays(rand(0, 30));
            
            $program = Program::firstOrCreate(
                ['name' => $data['name']],
                [
                    'description' => 'A comprehensive program designed to help you achieve your wellness goals.',
                    'category' => $data['category'],
                    'start_date' => now()->addWeek(),
                    'end_date' => now()->addWeeks(12),
                    'enrollment_deadline' => now()->addDays(3),
                    'capacity' => rand(15, 30),
                    'enrolled_count' => 0,
                    'status' => ['active', 'completed'][rand(0, 1)],
                    'coordinator_id' => $data['coordinator']->id,
                ]
            );
            
            $program->created_at = $createdDate;
            $program->save();
            $programs[] = $program;
        }

        $program1 = $programs[0] ?? null;
        $program2 = $programs[1] ?? null;
        $program3 = $programs[2] ?? null;
        $program4 = $programs[3] ?? null;

        // Create Sessions for each program
        if ($program1) {
            for ($i = 1; $i <= 12; $i++) {
                Session::create([
                    'program_id' => $program1->id,
                    'topic' => "Week $i: Weight Loss Session",
                'description' => "Weekly check-in and workout session",
                'facilitator' => 'Sarah Johnson',
                'location' => 'Fitness Center',
                'session_date' => now()->addWeeks($i)->setTime(18, 0),
                'duration_minutes' => 60,
                'status' => 'scheduled',
            ]);
            }
        }

        if ($program2) {
            for ($i = 1; $i <= 8; $i++) {
                Session::create([
                    'program_id' => $program2->id,
                    'topic' => "Session $i: Stress Management",
                    'description' => "Learn and practice stress reduction",
                    'facilitator' => 'Michael Chen',
                    'location' => 'Wellness Room',
                    'session_date' => now()->addWeeks($i + 1)->setTime(17, 0),
                    'duration_minutes' => 90,
                    'status' => 'scheduled',
                ]);
            }
        }

        // Register participants with varied dates
        foreach (array_slice($participants, 0, 20) as $index => $participant) {
            $registrationDate = now()->subMonths(rand(0, 5))->subDays(rand(0, 30));
            $programToRegister = $programs[array_rand($programs)];
            
            $registration = Registration::firstOrCreate(
                [
                    'user_id' => $participant->id,
                    'program_id' => $programToRegister->id
                ],
                [
                    'health_goals' => 'Want to improve my wellness and health',
                    'status' => 'registered',
                    'registered_at' => $registrationDate,
                ]
            );
            
            $registration->created_at = $registrationDate;
            $registration->save();
            
            $programToRegister->increment('enrolled_count');
        }

        // System Settings
        SystemSetting::firstOrCreate(
            ['key' => 'max_active_programs'],
            [
                'value' => '3',
                'description' => 'Maximum number of active programs per participant',
            ]
        );

        SystemSetting::firstOrCreate(
            ['key' => 'wellness_categories'],
            [
                'value' => 'Fitness,Mental Health,Wellness,Nutrition,Yoga',
                'description' => 'Available wellness program categories',
            ]
        );

        SystemSetting::firstOrCreate(
            ['key' => 'metric_templates'],
            [
                'value' => 'Weight,Blood Pressure,Heart Rate,BMI,Body Fat %',
                'description' => 'Available health metric templates',
            ]
        );

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@wellness.com / password');
        $this->command->info('Coordinator: coordinator1@wellness.com / password');
        $this->command->info('Participant: participant1@wellness.com / password');
    }
}
