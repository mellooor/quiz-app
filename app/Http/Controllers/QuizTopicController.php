<?php

namespace App\Http\Controllers;

use App\Models\QuizTopic;
use Illuminate\Http\Request;

class QuizTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $topics = QuizTopic::all();

        return view('quiz-topics')->with('topics', $topics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|unique:quiz_topics|max:255',
        ]);

        QuizTopic::create(['topic' => $request->input('topic')]);

        return back()->with('status', 'Quiz topic has been created.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $quizTopicID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $quizTopicID)
    {
        $request->validate([
            'topic' => 'required|string|unique:quiz_topics|max:255',
        ]);

        // Verify that the referenced quiz topic exists in the DB.
        $quizTopic = QuizTopic::findOrFail($quizTopicID);

        $quizTopic->topic = $request->input('topic');

        $quizTopic->save();

        return back()->with('status', 'Quiz topic has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $quizTopicID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $quizTopicID)
    {
        // Verify that the referenced quiz topic exists in the DB.
        $quizTopic = QuizTopic::findOrFail($quizTopicID);

        $quizTopic->delete();

        return back()->with('status', 'Quiz topic has been deleted.');
    }
}
