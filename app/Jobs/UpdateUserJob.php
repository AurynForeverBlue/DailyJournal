<?php

namespace App\Jobs;

use App\Mail\UpdateUserMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UpdateUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string $updated_item */
    protected $updated_item;

    /** @var array $old_user_data */
    protected $old_user_data;

    /** @var string $new_user_data */
    protected $new_user_data;

    /**
     * Create a new job instance.
     */
    public function __construct($updated_item, $old_user_data, $new_user_data)
    {
        $this->updated_item = $updated_item;
        $this->old_user_data = $old_user_data;
        $this->new_user_data = $new_user_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->old_user_data["email"])->send(new UpdateUserMail());
        User::where('user_id', $this->old_user_data["user_id"])
                ->update([
                    $this->updated_item => $this->new_user_data
                ]);
    }
}
