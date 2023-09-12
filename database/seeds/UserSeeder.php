<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // 7c4a8d09ca3762af61e59520943dc26494f8941b = 123456
        // d7316a3074d562269cf4302e4eed46369b523687 = user1234

        DB::table('users')->insertOrIgnore([
            ['login' => 'ADMIN', 'name' => 'ADMINISTRADOR', 'password' => '7c4a8d09ca3762af61e59520943dc26494f8941b', 'is_admin' => true, 'created_at' => now()],
            ['login' => 'USER', 'name' => 'USUARIO', 'password' => 'd7316a3074d562269cf4302e4eed46369b523687', 'is_admin' => false, 'created_at' => now()]
        ]);
    }
}
