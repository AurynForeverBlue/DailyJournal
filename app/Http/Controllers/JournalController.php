<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Http\Requests\StoreJournalRequest;
use App\Http\Requests\UpdateJournalRequest;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.journal.index', [
            "journals" => Journal::all()->sortByDesc('created_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.journal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJournalRequest $request)
    {
        $request_data = $request->validated();
        
        $new_user_data = [
            'user_id' => Auth::user()->id,
            'title' => $request_data['title'],
            'body' => $request_data['body'],
        ];

        Journal::create($new_user_data);

        return redirect("/")->with('succes', 'Journal has been posted');
    }

    /**
     * Display the specified resource.
     */
    public function show($journal_id)
    {
        return view('pages.journal.show', [
            "journal" => Journal::where("journal_id", $journal_id)->first(),
            "user_id" => Auth::user()->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($journal_id)
    {
        return view('pages.journal.edit', [
            "journal" => Journal::where("journal_id", $journal_id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJournalRequest $request)
    {
        $request_data = $request->validated();

        Journal::where('journal_id', $request_data["journal_id"])
                ->update([
                    'title' => $request_data["title"],
                    'body' => $request_data["body"]
                ]);

        return redirect("/")->with('succes', 'Journal has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($journal_id)
    {
        Journal::where('journal_id', $journal_id)->delete();

        return redirect("/")->with('succes', 'Journal has been deleted');
    }
}
