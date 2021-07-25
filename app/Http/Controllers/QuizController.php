<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display all quizzes.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $quizzes = Quiz::paginate(5);
        $title = 'All Quizzes';

        return view('show-all-quizzes')->with('data', [
            'quizzes' => $quizzes,
            'title' => $title,
        ]);
    }

    /**
     * Display all quizzes by topic.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexByTopic(int $topicID)
    {
        if ($topic = QuizTopic::find($topicID))
        {
            $quizzes = Quiz::where('topic_id', $topicID)->paginate(5);
            $title = $topic->topic . ' Quizzes';

            return view('show-quizzes-by-topic')->with('data', [
                'quizzes' => $quizzes,
                'topic' => $topic->topic,
                'title' => $title,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Display all quizzes by author.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexByUser(int $userID)
    {
        if ($user = User::find($userID))
        {
            $quizzes = Quiz::where('author_id', $userID)->paginate(5);
            $title = $user->name . '\'s Quizzes';

            return view('show-quizzes-by-author')->with('data', [
                'quizzes' => $quizzes,
                'author' => $user,
                'title' => $title
            ]);
        } else {
            abort(404);
        }
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
     * Display an individual quiz.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Quiz $quiz)
    {
        // Return the quiz page if the specified quiz exists in the DB, otherwise return a 404.
        if ($quiz->exists())
        {
            return view('show-quiz')->with('quiz', $quiz->first());
        } else
        {
            abort(404);
        }
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
