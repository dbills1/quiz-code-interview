<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            User::create([
                'name' => 'Super-Administrator',
                'email' => 'superadmin@quiz.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12341234'),
                'is_admin' => 1
            ]);

            $this->command->info("Successfully create Super Administrator User");

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
        }
    }
}
