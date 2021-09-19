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
     * @param  int  $userID
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
     * @param  int  $quizID
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $quizID)
    {
        // Return the quiz edit page if the specified quiz exists in the DB, otherwise return a 404.
        if ($quiz = Quiz::find($quizID))
        {
            // Verify that the user is the author of the quiz. If not, redirect them back to the home page.
            if ($quiz->author->id === Auth::user()->id)
            {
                // Retrieve all of the quiz topics so that they can be passed to the blade template dropdown.
                $topics = QuizTopic::all();

                return view('edit-quiz')->with('data', [
                    'quiz' => $quiz,
                    'topics' => $topics,
                ]);
            } else {
                return redirect()->route('home');
            }
        } else
        {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $quizID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $quizID)
    {
        // Attempt to update the quiz if the specified quiz exists in the DB, otherwise return back to the edit quiz page with an error.
        if ($quiz = Quiz::find($quizID)) {
            $request->validate([
                'title' => 'required|string|unique:quizzes,title,' . $quiz->id .'|max:255',
                'topic_id' => 'nullable|integer|exists:quiz_topics,id|max:255',
            ]);

            // Verify that the user is the author of the quiz. If not, redirect them back to the home page.
            if ($quiz->author->id === Auth::user()->id) {
                $quiz->topic_id = $request->input('topic_id');
                $quiz->title = $request->input('title');

                $quiz->save();

                return redirect()->back()->with('status', 'Quiz updated.');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->back()->withErrors(['no-quiz-found' => 'No quiz was found with the parameters supplied.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $quizID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $quizID)
    {
        // Attempt to delete the quiz if it exists in the database, otherwise return to the home page with an error.
        if ($quiz = Quiz::find($quizID)) {
            // If the current user is the author of the quiz, delete it and return to the home page with a success message. Otherwise, return to the home page with an error.
            if ($quiz->author_id === Auth::user()->id)
            {
                $quiz->delete();

                return redirect()->route('quizzes-by-user', Auth::user()->id)->with('status', 'Quiz deleted.');
            } else {
                return redirect()->route('home')->withErrors(['not-authorised' => 'You are not authorised to delete this quiz.']);
            }
        } else
        {
            return redirect()->route('home')->withErrors(['no-quiz-found' => 'No quiz was found with the parameters supplied.']);
        }
    }
}
