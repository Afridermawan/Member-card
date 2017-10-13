<?php

use Phinx\Seed\AbstractSeed;
use Cocur\Slugify\Slugify;

class Produks extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $slugify = new Slugify();

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->sentence($nbWords = 20, $variableNbWords = true);
            $data[] = [
                'name'        => $name,
                'slug'        => $slugify->slugify($name),
                'stok'        => $faker->randomNumber(2),
                'description' => $faker->sentence($nbWords = 100, $variableNbWords = true),
                'image'       => $faker->imageUrl($width = 640, $height = 480),
                'harga'       => $faker->randomNumber(7),
            ];
        }

        $this->insert('produks', $data);
    }
}
