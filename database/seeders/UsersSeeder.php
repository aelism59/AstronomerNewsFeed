<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::create([
            'email'=>'admin@astronomerguy.project',
            'password'=>Hash::make('astronomer_guy'),
            'name'=>'Astronomy Guy Admin',
        ]);
        $user->roles()->attach(Role::where('slug', 'admin')->first());

        $user = User::create([
            'email'=>'editor@astronomerguy.project',
            'password'=>Hash::make('1234'),
            'name'=>'Editor',
        ]);
        $user->roles()->attach(Role::where('slug', 'editor')->first());

        $user = User::create([
            'email'=>'user@astronomerguy.project',
            'password'=>Hash::make('1234'),
            'name'=>'User',
        ]);
        $user->roles()->attach(Role::where('slug', 'user')->first());
    }
}
