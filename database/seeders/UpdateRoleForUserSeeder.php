<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateRoleForUserSeeder extends Seeder
{
    /**
     * Menjalankan seeder.
     *
     * @return void
     */
    public function run()
    {
        // Mengubah role pengguna dengan email tertentu menjadi 'admin'
        $user = User::where('email', 'rafliadipratma@gmail.com')->first();
        if ($user) {
            $user->role = 'admin';  // Mengubah role menjadi 'admin'
            $user->save();
        }
    }
}
