<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GetUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:user {userEmail? : User Id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get info about User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument("userEmail");
        if(!$email){
            $email = $this->ask("Enter User email");
        }
        $user = User::where("email", "=", $email)->first();
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
