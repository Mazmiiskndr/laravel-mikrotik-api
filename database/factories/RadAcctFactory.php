<?php

namespace Database\Factories;

use App\Models\RadAcct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RadAcct>
 */
class RadAcctFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RadAcct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'acctsessionid' => str()->random(8),
            'acctuniqueid' => md5($this->faker->unique()->safeEmail),
            'username' => $this->faker->userName,
            'groupname' => " ",
            'realm' => " ",
            'nasipaddress' => $this->faker->ipv4,
            'nasportid' => 'bridge1',
            'nasporttype' => 'Wireless-802.11',
            'acctstarttime' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
            'acctsessiontime' => $this->faker->numberBetween(100, 500),
            'acctinputoctets' => $this->faker->numberBetween(1000000, 5000000),
            'acctoutputoctets' => $this->faker->numberBetween(1000000, 5000000),
            'calledstationid' => 'hotspot1',
            'callingstationid' => $this->faker->macAddress,
            'acctterminatecause' => 'User-Request',
            'framedipaddress' => $this->faker->ipv4,
            'framedipv6address' => $this->faker->ipv6,
            'framedipv6prefix' => str()->random(45),
            'framedinterfaceid' => str()->random(10),
            'delegatedipv6prefix' => str()->random(10),
            'acctupdatetime' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
        ];
    }
}
