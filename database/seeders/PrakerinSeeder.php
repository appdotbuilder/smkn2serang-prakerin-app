<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyRepresentative;
use App\Models\DailyJournal;
use App\Models\PrakerinPlacement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PrakerinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo users with specific roles
        $studentUser = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'student@prakerin.test',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $teacherUser = User::create([
            'name' => 'Ibu Sari Dewi, S.Pd',
            'email' => 'teacher@prakerin.test',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        $companyUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'company@prakerin.test',
            'password' => Hash::make('password'),
            'role' => 'company_representative',
            'email_verified_at' => now(),
        ]);

        // Create companies
        $companies = Company::factory(10)->active()->create();
        $mainCompany = $companies->first();

        // Create students
        $students = collect();
        for ($i = 0; $i < 25; $i++) {
            $user = User::factory()->create(['role' => 'student']);
            $student = Student::factory()->create(['user_id' => $user->id]);
            $students->push($student);
        }

        // Create demo student
        $demoStudent = Student::create([
            'user_id' => $studentUser->id,
            'nisn' => '1234567890',
            'name' => 'Ahmad Rizki',
            'class' => 'XII RPL 1',
            'major' => 'Rekayasa Perangkat Lunak',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 123, Kota Serang',
            'birth_date' => '2005-05-15',
            'gender' => 'male',
            'parent_name' => 'Bapak Ahmad Soleh',
            'parent_phone' => '081234567891',
        ]);

        // Create teachers
        $teachers = collect();
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create(['role' => 'teacher']);
            $teacher = Teacher::factory()->supervisingTeacher()->create(['user_id' => $user->id]);
            $teachers->push($teacher);
        }

        // Create demo teacher
        $demoTeacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => '19800101200801001',
            'name' => 'Ibu Sari Dewi, S.Pd',
            'phone' => '081234567892',
            'address' => 'Jl. Pendidikan No. 456, Kota Serang',
            'subject' => 'Pemrograman Web',
            'role' => 'supervising_teacher',
        ]);

        // Create company representative
        $companyRep = CompanyRepresentative::create([
            'user_id' => $companyUser->id,
            'company_id' => $mainCompany->id,
            'name' => 'Budi Santoso',
            'position' => 'IT Manager',
            'phone' => '081234567893',
            'email' => 'budi@company.com',
        ]);

        // Create prakerin placements
        $placements = collect();
        
        // Create demo placement for demo student
        $demoPlacement = PrakerinPlacement::create([
            'student_id' => $demoStudent->id,
            'company_id' => $mainCompany->id,
            'supervising_teacher_id' => $demoTeacher->id,
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonth(),
            'status' => 'ongoing',
            'notes' => 'Penempatan di divisi IT untuk belajar pengembangan web dan maintenance sistem.',
        ]);

        // Create other placements
        foreach ($students->take(20) as $student) {
            $placement = PrakerinPlacement::create([
                'student_id' => $student->id,
                'company_id' => $companies->random()->id,
                'supervising_teacher_id' => $teachers->random()->id,
                'start_date' => fake()->dateTimeBetween('-3 months', '-1 month'),
                'end_date' => fake()->dateTimeBetween('now', '+2 months'),
                'status' => fake()->randomElement(['ongoing', 'planned']),
                'notes' => fake()->optional()->paragraph(),
            ]);
            $placements->push($placement);
        }

        // Create completed placements
        foreach ($students->skip(20) as $student) {
            $placement = PrakerinPlacement::create([
                'student_id' => $student->id,
                'company_id' => $companies->random()->id,
                'supervising_teacher_id' => $teachers->random()->id,
                'start_date' => fake()->dateTimeBetween('-8 months', '-6 months'),
                'end_date' => fake()->dateTimeBetween('-5 months', '-3 months'),
                'status' => 'completed',
                'final_grade' => fake()->numberBetween(75, 95),
                'teacher_feedback' => fake()->paragraph(),
                'company_feedback' => fake()->paragraph(),
            ]);
            $placements->push($placement);
        }

        // Create daily journals for demo placement
        $journalDates = [];
        $startDate = $demoPlacement->start_date;
        $endDate = min(now(), $demoPlacement->end_date);
        
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate && count($journalDates) < 30) {
            // Skip weekends
            if ($currentDate->format('N') < 6) {
                $journalDates[] = clone $currentDate;
            }
            $currentDate->addDay();
        }

        foreach (array_slice($journalDates, 0, 25) as $date) {
            DailyJournal::create([
                'placement_id' => $demoPlacement->id,
                'journal_date' => $date,
                'activities' => fake()->randomElement([
                    'Melakukan maintenance server dan update sistem keamanan perusahaan',
                    'Mengembangkan fitur baru untuk aplikasi internal menggunakan Laravel',
                    'Membuat dokumentasi API untuk integrasi dengan sistem eksternal',
                    'Melakukan testing aplikasi web dan memperbaiki bug yang ditemukan',
                    'Mengikuti meeting tim untuk planning sprint development selanjutnya',
                    'Menganalisis database performance dan melakukan optimasi query',
                    'Membuat laporan progress development untuk manajemen',
                    'Belajar implementasi CI/CD pipeline menggunakan GitLab',
                ]),
                'learning_outcomes' => fake()->optional()->randomElement([
                    'Memahami pentingnya security dalam maintenance server',
                    'Menguasai konsep MVC dalam framework Laravel',
                    'Belajar best practices dalam dokumentasi teknis',
                    'Memahami metodologi testing yang efektif',
                    'Meningkatkan kemampuan komunikasi dalam tim',
                    'Memahami optimasi database untuk performa yang lebih baik',
                    'Belajar menyusun laporan teknis yang mudah dipahami',
                    'Memahami konsep DevOps dan automation',
                ]),
                'challenges' => fake()->optional()->randomElement([
                    'Kesulitan debugging error kompleks di production environment',
                    'Perlu adaptasi dengan coding standards perusahaan',
                    'Tantangan dalam memahami business logic yang kompleks',
                    'Kesulitan reproduksi bug yang sporadis',
                    'Perlu waktu ekstra untuk memahami infrastructure yang ada',
                    'Query optimization memerlukan pemahaman yang mendalam',
                    'Menyusun laporan yang balance antara teknis dan bisnis',
                    'Konfigurasi pipeline yang rumit dan banyak dependency',
                ]),
                'attendance_status' => fake()->randomElement(['present', 'present', 'present', 'present', 'present', 'present', 'present', 'present', 'sick', 'permission']),
                'clock_in' => fake()->time('H:i', '09:00'),
                'clock_out' => fake()->time('H:i', '17:00'),
                'teacher_comment' => fake()->optional(30)->sentence(),
                'company_comment' => fake()->optional(20)->sentence(),
                'teacher_rating' => fake()->optional(40)->numberBetween(3, 5),
                'company_rating' => fake()->optional(30)->numberBetween(3, 5),
            ]);
        }

        // Create some journals for other ongoing placements
        foreach ($placements->where('status', 'ongoing')->take(10) as $placement) {
            $journalCount = fake()->numberBetween(5, 20);
            DailyJournal::factory($journalCount)->create([
                'placement_id' => $placement->id,
            ]);
        }
    }
}