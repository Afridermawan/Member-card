<?php

use Phinx\Seed\AbstractSeed;
use Cocur\Slugify\Slugify;

class Article extends AbstractSeed
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
            $title = $faker->sentence($nbWords = 6, $variableNbWords = true);
            $data[] = [
                'category_id' => rand(1,10),
                'slug'        => $slugify->slugify($title),
                'title'       => $title,
                'content'     => $faker->sentence($nbWords = 100, $variableNbWords = true),
                'thumbnail'   => $faker->imageUrl($width = 640, $height = 480),
            ];
        }

        $this->insert('articles', $data);
    }
}
