<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'bic:admin-create {email : Admin email address} {--name= : Admin display name}';
    protected $description = 'Securely create or update a BIC admin user';

    public function handle(): int
    {
        $password = $this->secret('Enter a strong password');
        $confirmation = $this->secret('Confirm the password');
        if (! is_string($password) || strlen($password) < 12 || $password !== $confirmation) {
            $this->error('Passwords must match and contain at least 12 characters.');
            return self::FAILURE;
        }
        User::updateOrCreate(
            ['email' => $this->argument('email')],
            ['name' => $this->option('name') ?: 'BIC Administrator', 'password' => Hash::make($password), 'is_admin' => true]
        );
        $this->info('Admin user is ready.');
        return self::SUCCESS;
    }
}
