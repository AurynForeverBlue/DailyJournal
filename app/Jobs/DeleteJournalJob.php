<?php

namespace App\Jobs;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteJournalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array $journal_data */
    protected $journal_data;
    
    /**
     * Create a new job instance.
     */
    public function __construct($journal_data)
    {
        $this->journal_data = $journal_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::where('journal_id', $this->journal_data["journal_id"])
                ->delete();
    }
}
