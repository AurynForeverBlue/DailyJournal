<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJournalRequest;
use App\Http\Requests\UpdateJournalRequest;
use App\Jobs\CreateJournalJob;
use App\Jobs\DeleteJournalJob;
use App\Traits\Uuid;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;
use App\Jobs\UpdateJournalJob;

class JournalController extends Controller
{
    use Uuid;

    /**
     * Display a listing of the journals
     */
    public function index()
    {
        return view('pages.journal.index', [
            "journals" => Journal::all()->sortByDesc('created_at')
        ]);
    }

    /**
     * Show the form for creating a new journal
     */
    public function create()
    {
        return view('pages.journal.create');
    }

    /**
     * Store a newly created journal in database
     * @param CreateJournalRequest $request
     */
    public function store(CreateJournalRequest $request)
    {
        $request_data = $request->validated();

        $journal = new Journal();
        $dailyuploadcheck = $journal->DailyUploadCheck();;
        
        if ($dailyuploadcheck != null) {
            return redirect("/")->with('error', "Can't upload more than one journal a day");
        }
        
        $new_user_data = [
            'journal_id' => $this->createUuid(),
            'user_id' => Auth::user()->user_id,
            'title' => $request_data['title'],
            'body' => $request_data['body'],
        ];

        CreateJournalJob::dispatch($new_user_data);

        return redirect("/")->with('succes', 'Journal has been posted');
    }

    /**
     * Display the specified journal
     * @param string $journal_id
     */
    public function show($journal_id)
    {
        if (Auth::check()){
            $user_id = Auth::user()->user_id;
        }
        else {
            $user_id = null;
        }
        
        return view('pages.journal.show', [
            "journal" => Journal::where("journal_id", $journal_id)->first(),
            "user_id" => $user_id
        ]);
    }

    /**
     * Show the form for editing the specified journal
     * @param string $journal_id
     */
    public function edit($journal_id)
    {
        $journal_data = Journal::where("journal_id", $journal_id)->first();

        if ($journal_data["user_id"] == Auth::user()->user_id) {
            return view('pages.journal.edit', [
                "journal" => $journal_data
            ]);
        }
        else {
            return redirect("/banuser/".Auth::user()->user_id);
        }
    }

    /**
     * Update the specified journal in database
     * @param UpdateJournalRequest $request
     */
    public function update(UpdateJournalRequest $request)
    {
        $request_data = $request->validated();

        $updated_journal = [
            'journal_id' => $request_data["journal_id"],
            'user_id' => Auth::user()->user_id,
            'title' => $request_data["title"],
            'body' => $request_data["body"]
        ];
        
        UpdateJournalJob::dispatch($updated_journal);

        return redirect("/")->with('succes', 'Journal has been updated');
    }

    /**
     * Remove the specified Journal from database
     * @param string $journal_id
     */
    public function destroy($journal_id)
    {   
        $journal_data = [
            'journal_id' => $journal_id,
        ];

        DeleteJournalJob::dispatch($journal_data);
        
        return redirect("/")->with('succes', 'Journal has been deleted');
    }
}
