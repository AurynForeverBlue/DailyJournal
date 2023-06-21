<?php

namespace App\Jobs;

use App\Mail\EmailValidationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UpdateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array $user_data */
    protected $user_data;

    /** @var string $new_user_email */
    protected $new_user_email;

    /**
     * Create a new job instance.
     */
    public function __construct($user_data, $new_user_email)
    {
        $this->user_data = $user_data;
        $this->new_user_email = $new_user_email;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user_data["email"])->send(new EmailValidationMail());
        User::where('user_id', $this->user_data["user_id"])
        ->update([
            "email" => $this->new_user_email
        ]);
    }
}
