<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['Pemrograman Dasar', 'Basis Data', 'Jaringan Komputer', 'Multimedia', 'Matematika', 'Bahasa Indonesia'];
        $classes = ['XII RPL 1', 'XII RPL 2', 'XII TKJ 1', 'XII TKJ 2', 'XII MM 1', 'XII MM 2'];
        
        return [
            'user_id' => User::factory(),
            'nip' => $this->faker->unique()->numerify('####################'),
            'name' => $this->faker->name(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->optional()->address(),
            'subject' => $this->faker->optional()->randomElement($subjects),
            'role' => $this->faker->randomElement(['supervising_teacher', 'homeroom_teacher', 'vice_principal']),
            'homeroom_class' => $this->faker->optional()->randomElement($classes),
        ];
    }

    /**
     * Indicate that the teacher is a supervising teacher.
     */
    public function supervisingTeacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'supervising_teacher',
            'homeroom_class' => null,
        ]);
    }

    /**
     * Indicate that the teacher is a homeroom teacher.
     */
    public function homeroomTeacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'homeroom_teacher',
            'homeroom_class' => $this->faker->randomElement(['XII RPL 1', 'XII RPL 2', 'XII TKJ 1', 'XII TKJ 2', 'XII MM 1', 'XII MM 2']),
        ]);
    }
}