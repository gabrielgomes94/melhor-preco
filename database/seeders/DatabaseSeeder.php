<?php

namespace Database\Seeders;

use Src\Users\Infrastructure\Laravel\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User();
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('asimov123');
        $user->name = 'Admin';
        $user->phone = '+5511987654321';
        $user->fiscal_id = '43987867086';
        $user->markEmailAsVerified();
        $user->save();
    }
}
