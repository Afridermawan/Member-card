<?php

use Phinx\Seed\AbstractSeed;

class ArticleTag extends AbstractSeed
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

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'tag_id'       => rand(1,10),
                'article_id'   => rand(1,100),
            ];
        }

        $this->insert('article_tags', $data);
    }
}
