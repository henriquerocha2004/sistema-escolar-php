<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class RoomFixures extends Fixture
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (range(1, 1000) as $index => $number) {
            $id = Uuid::v4()->__toString();
            $this->connection->executeQuery("INSERT INTO rooms (id, code, capacity, description) VALUES (:id, :code, :capacity, :description)", [
                'id' => $id,
                'code' => $faker->languageCode(),
                'capacity' => $faker->numberBetween(1, 100),
                'description' => $faker->jobTitle(),
            ]);
        }
    }
}
