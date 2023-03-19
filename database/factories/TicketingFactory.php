<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'subject' => $this->faker->randomElement(['Order online with supplier',"check bank for payments","write an email to supplier" ]),
            'status' => $this->faker->randomElement(["closed"]),
            'order_number' => $this->faker->numberBetween(2859,3512),
            'due_date'=> $this->faker->dateTimeThisYear(),
            'notes' => $this->faker->sentence()
        ];
    }
}
