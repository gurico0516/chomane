<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Allowance\Entities\Allowance>
 */
class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Domains\Expense\Entities\Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'allowance_id' => $this->faker->randomDigitNotNull, 
            'expense' => $this->faker->randomNumber(4),
            'memo' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['1', '2', '3', '4']), // 1:雑費、2:食費、3:消耗品費、4:交通費
            'user_id' => $this->faker->randomDigitNotNull,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
        ]);
    }
}
