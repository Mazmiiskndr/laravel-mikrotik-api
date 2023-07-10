<?php

namespace Database\Factories;

use App\Models\HotelRoom;
use App\Models\Services;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelRoom>
 */
class HotelRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HotelRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => strtoupper(str()->orderedUuid()),
            'room_number' => $this->faker->randomNumber(2),
            'name' => $this->faker->name,
            'password' => $this->faker->password,
            'folio_number' => $this->faker->uuid,
            'service_id' => Services::first()->id, // mengambil id pertama dari tabel services
            'default_cron_type' => $this->faker->word,
            'status' => $this->faker->randomElement(['active', 'deactive']),
            'edit' => $this->faker->randomElement([0, 1]),
            'change_service_end_time' => $this->faker->dateTime,
            'arrival' => $this->faker->dateTime,
            'departure' => $this->faker->dateTime,
            'no_posting' => $this->faker->randomElement(['Y', 'N']),
        ];
    }
}
