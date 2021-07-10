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
        return view('quiz-topics');
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
     * @param  \App\Models\QuizTopic  $quizTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizTopic $quizTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizTopic  $quizTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizTopic $quizTopic)
    {
        //
    }
}
