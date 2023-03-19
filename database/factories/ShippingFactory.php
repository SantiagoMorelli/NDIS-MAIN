<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shipping;

class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     *  
     * @return array
     */
    protected $model = Shipping::class;

    public function definition()
    {
        return [
            //
            'courier_company' => $this->faker->company(),
            'tracking_number' => $this->faker->ean13(),
            'order_number' => $this->faker->numberBetween(2859,3512),
            'expected_time_of_arrival'=> $this->faker->dateTimeThisYear(),
            'dispatch_time' =>$this->faker->time(),
        ];
    }
}
