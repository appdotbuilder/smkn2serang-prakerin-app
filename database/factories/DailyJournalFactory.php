<?php

namespace Database\Factories;

use App\Models\DailyJournal;
use App\Models\PrakerinPlacement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyJournal>
 */
class DailyJournalFactory extends Factory
{
    protected $model = DailyJournal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activities = [
            'Melakukan maintenance sistem komputer dan troubleshooting masalah hardware',
            'Mengembangkan aplikasi web menggunakan Laravel dan Vue.js',
            'Membuat desain grafis untuk media promosi perusahaan',
            'Melakukan backup data dan update sistem keamanan',
            'Mengikuti meeting dengan tim IT untuk project planning',
            'Melakukan testing aplikasi dan dokumentasi bug report',
            'Membuat presentasi untuk client mengenai fitur aplikasi baru',
            'Melakukan instalasi dan konfigurasi software untuk karyawan baru',
        ];

        $learningOutcomes = [
            'Memahami proses troubleshooting yang sistematis',
            'Belajar framework Laravel untuk pengembangan web',
            'Meningkatkan skill desain menggunakan Adobe Creative Suite',
            'Memahami pentingnya backup data dan security measures',
            'Belajar komunikasi efektif dalam tim kerja',
            'Memahami proses testing dan quality assurance',
            'Meningkatkan kemampuan presentasi dan komunikasi',
            'Belajar best practices dalam instalasi software enterprise',
        ];

        $challenges = [
            'Kesulitan debugging error yang kompleks',
            'Perlu waktu lebih lama untuk memahami struktur database',
            'Tantangan dalam menggunakan tools design yang baru',
            'Prosedur backup yang rumit dan memakan waktu',
            'Komunikasi dengan tim yang berbeda background',
            'Menemukan bug yang sulit direproduksi',
            'Nervous saat presentasi di depan client',
            'Compatibility issues dengan sistem yang sudah ada',
        ];

        return [
            'placement_id' => PrakerinPlacement::factory(),
            'journal_date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'activities' => $this->faker->randomElement($activities),
            'learning_outcomes' => $this->faker->optional()->randomElement($learningOutcomes),
            'challenges' => $this->faker->optional()->randomElement($challenges),
            'attendance_status' => $this->faker->randomElement(['present', 'absent', 'sick', 'permission']),
            'clock_in' => $this->faker->optional()->time('H:i', '09:00'),
            'clock_out' => $this->faker->optional()->time('H:i', '17:00'),
            'teacher_comment' => $this->faker->optional()->sentence(),
            'company_comment' => $this->faker->optional()->sentence(),
            'teacher_rating' => $this->faker->optional()->numberBetween(1, 5),
            'company_rating' => $this->faker->optional()->numberBetween(1, 5),
        ];
    }
}