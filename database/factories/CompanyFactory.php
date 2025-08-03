<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = [
            'PT Astra International',
            'PT Telkom Indonesia',
            'PT Bank Central Asia',
            'PT Indofood Sukses Makmur',
            'PT Unilever Indonesia',
            'PT Pertamina',
            'PT Garuda Indonesia',
            'PT PLN (Persero)',
            'PT Semen Indonesia',
            'PT Krakatau Steel',
        ];

        return [
            'name' => $this->faker->randomElement($companies),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional()->companyEmail(),
            'contact_person' => $this->faker->name(),
            'contact_person_phone' => $this->faker->phoneNumber(),
            'description' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the company is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
}