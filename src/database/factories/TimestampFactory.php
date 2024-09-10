<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Timestamp;

class TimestampFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dummyDate = $this->faker->dateTimeThisMonth;

        return [
            'date_work' => $dummyDate->format('Y-m-d'),
            'punchIn' => $dummyDate->format('H:i:s'),
            'punchOut' => $dummyDate->modify('+9hour')->format('H:i:s'),
            'user_id' => $this->faker->numberBetween(1,30),
        ];
    }
}
