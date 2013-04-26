<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        // Set up an admin account without hardcoding too much
        echo "Enter admin username (admin): ";
        $username = trim(fgets(STDIN));

        echo "Enter email (admin@clawandquill.net): ";
        $email = trim(fgets(STDIN));

        echo "Enter password: ";
        $password = trim(fgets(STDIN));

        User::create([
            'username' => ($username ?: 'admin'),
            'email' => ($email ?: 'admin@clawandquill.net'),
            'password' => Hash::make($password),
            'is_admin' => true
        ]);
    }
}
