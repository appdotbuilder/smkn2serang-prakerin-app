<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\CompanyRepresentative;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyRepresentative>
 */
class CompanyRepresentativeFactory extends Factory
{
    protected $model = CompanyRepresentative::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = ['IT Manager', 'HR Manager', 'Operations Manager', 'Project Manager', 'Supervisor'];
        
        return [
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement($positions),
            'phone' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->optional()->companyEmail(),
        ];
    }
}