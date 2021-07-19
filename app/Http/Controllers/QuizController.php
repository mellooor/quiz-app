<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the create quiz view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Retrieve all of the quiz topics so that they can be passed to the blade template dropdown.
        $topics = QuizTopic::all();

        return view('create-quiz')->with('topics', $topics);
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
            'title' => 'required|string|unique:quizzes|max:255',
            'topic_id' => 'nullable|integer|exists:quiz_topics,id|max:255',
        ]);

        $quiz = new Quiz();
        $quiz->author_id = Auth::user()->id;
        $quiz->topic_id = $request->input('topic_id');
        $quiz->title = $request->input('title');

        $quiz->save();

        return redirect()->route('create-quiz-questions', ['id' => $quiz->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
