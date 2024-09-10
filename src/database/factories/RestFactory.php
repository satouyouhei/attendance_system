<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rest;
use App\Models\Timestamp;


class RestFactory extends Factory
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
            'rest_start' => $dummyDate->format('H:i:s'),
            'rest_end' => $dummyDate->modify('+1hour')->format('H:i:s'),
            'timestamp_id' => function () {
                return Timestamp::factory()->create()->id;
            },
        ];
    }
}
