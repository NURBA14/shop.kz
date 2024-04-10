<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new User in console';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask("Enter name");
        $email = $this->ask("Enter email");
        $ver = User::where("email", "=", $email)->count();
        if($ver >= 1){
            $this->error("Such an email address exists");
            return self::FAILURE;
        }
        $password = $this->ask("Enter password");
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "password" => bcrypt($password),
        ]);
        $data = [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "Is_admin" => $user->getAdmin() ? "Admin" : "User",
            "created_at" => $user->created_at
        ];
        print_r($data);
        return self::SUCCESS;
    }
}
