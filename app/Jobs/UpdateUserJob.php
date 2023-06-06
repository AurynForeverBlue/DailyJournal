<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array $old_user_data */
    protected $old_user_data;

    /** @var array $user_data */
    protected $new_user_data;

    /**
     * Create a new job instance.
     */
    public function __construct($old_user_data, $new_user_data)
    {
        $this->old_user_data = $old_user_data;
        $this->new_user_data = $new_user_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::where('user_id', $this->old_user_data["user_id"])
                ->update([
                    'username' => $this->new_user_data["username"],
                    'email' => $this->new_user_data["email"],
                    'password' => $this->new_user_data["password"]
                ]);
    }
}
