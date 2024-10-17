<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {username} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user with a random password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('username');
        $email = $this->argument('email');

        // Abort if user already exists
        $user_exists = User::where('name', $name)->exists() || User::where('email', $email)->exists();
        if ($user_exists) {
            $this->info("User {$name} already exists");
            return;
        }

        $password_in_plain = Str::random(8);

        $user = new User();
        $user->password = Hash::make($password_in_plain);
        $user->email = $email;
        $user->name = $name;
        $user->save();

        $this->info("Created user {$name} with password: {$password_in_plain}");
    }
}
