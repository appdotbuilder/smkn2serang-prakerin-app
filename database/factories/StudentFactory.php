<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classes = ['XII RPL 1', 'XII RPL 2', 'XII TKJ 1', 'XII TKJ 2', 'XII MM 1', 'XII MM 2'];
        $majors = ['Rekayasa Perangkat Lunak', 'Teknik Komputer dan Jaringan', 'Multimedia'];
        
        return [
            'user_id' => User::factory(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name(),
            'class' => $this->faker->randomElement($classes),
            'major' => $this->faker->randomElement($majors),
            'phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->optional()->address(),
            'birth_date' => $this->faker->optional()->date('Y-m-d', '2005-12-31'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'parent_name' => $this->faker->optional()->name(),
            'parent_phone' => $this->faker->optional()->phoneNumber(),
        ];
    }
}