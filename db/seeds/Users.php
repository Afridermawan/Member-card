<?php

use Phinx\Seed\AbstractSeed;

class Users extends AbstractSeed
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

        $data[] = [
            'username'  => 'admin',
            'email'     => 'dev.membercard@gmail.com',
            'password'  => password_hash('membercard123', PASSWORD_DEFAULT),
            'phone'     => '0812-8533-8515',
            'role_id'   => 1,
            'status'    => 1
        ];

        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'username'  => $faker->userName,
                'email'     => $faker->email,
                'password'  => password_hash($faker->password, PASSWORD_DEFAULT),
                'phone'     => $faker->PhoneNumber,
                'role_id'   => 2,
                'status'    => 1
            ];
        }

        $post = $this->table('users');
        $post->insert($data)
             ->save();
    }
}
