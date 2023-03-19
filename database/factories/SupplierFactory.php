<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Supplier::class;

    public function definition()
    {
        return [
            //
            'contact_person'=>$this->faker->name($gender=null),
            'phone_number'=>$this->faker->phoneNumber()
        ];
    }
}
