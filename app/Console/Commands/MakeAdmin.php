<?php

namespace App\Console\Commands;

use App\Actions\Teams\CreateTeam;
use App\Enums\TeamRole;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class MakeAdmin extends Command
{
    protected $signature = 'make:admin {name} {email} {password?}';

    protected $description = 'Create a new admin user';

    public function handle(CreateTeam $createTeam): int
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password') ?? $this->secret('Password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', Password::defaults()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return Command::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => UserRole::Admin,
        ]);

        $createTeam->handle($user, "$user->name's Team", isPersonal: true);

        $this->info("Admin user [{$user->email}] created successfully.");

        return Command::SUCCESS;
    }
}
