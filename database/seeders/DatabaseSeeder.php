<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $token = User::factory(1)->create()[0]->createToken("super_token");
        echo "created one user with user token : " . $token->plainTextToken . "\n";
    }
}
