<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\PrakerinPlacement;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrakerinPlacement>
 */
class PrakerinPlacementFactory extends Factory
{
    protected $model = PrakerinPlacement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', '+1 month');
        $endDate = (clone $startDate)->modify('+3 months');
        
        return [
            'student_id' => Student::factory(),
            'company_id' => Company::factory(),
            'supervising_teacher_id' => Teacher::factory()->supervisingTeacher(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['planned', 'ongoing', 'completed']),
            'notes' => $this->faker->optional()->paragraph(),
            'final_grade' => $this->faker->optional()->numberBetween(70, 100),
            'teacher_feedback' => $this->faker->optional()->paragraph(),
            'company_feedback' => $this->faker->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the placement is ongoing.
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
            'start_date' => $this->faker->dateTimeBetween('-2 months', '-1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
        ]);
    }

    /**
     * Indicate that the placement is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_date' => $this->faker->dateTimeBetween('-6 months', '-4 months'),
            'end_date' => $this->faker->dateTimeBetween('-3 months', '-1 month'),
            'final_grade' => $this->faker->numberBetween(75, 95),
            'teacher_feedback' => $this->faker->paragraph(),
            'company_feedback' => $this->faker->paragraph(),
        ]);
    }
}