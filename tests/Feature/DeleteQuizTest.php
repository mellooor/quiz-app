<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteQuizTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * A user who isn't the author of any quizzes.
     */
    protected $nonQuizOwner;

    /** @var \App\Models\User
     *
     * A user whos owns quizzes that are used in the tests.
     */
    protected $quizOwner;

    /** @var \App\Models\User
     *
     * The quiz that's used in the tests.
     */
    protected $quiz;

    /** @var \App\Models\QuizTopic
     *
     * A quiz topic which is used in the tests.
     */
    protected $quizTopic;

    /** @var String
     *
     * The base URI to delete a quiz (ID of quiz one is suffixed to the string in the set up method).
     */
    protected $deleteQuizURI = '/delete-quiz';

    /** @var string
     *
     * The URI for the My Quizzes page which is used for some of the redirects.
     */
    protected $myQuizzesURI;

    /** @var string
     *
     * The URI for the home page which is used for some of the redirects.
     */
    protected $homeURI;

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->nonQuizOwner = User::factory()->create(); // New regular user is created who will be used in the tests.
        $this->quizOwner = User::factory()->admin()->create(); // New administrator is created who will be used in the tests as the quiz owner.
        $this->quizTopic = QuizTopic::factory()->create(); // A quiz topic that is used in the tests.
        $this->quiz = Quiz::factory()->create([
            'author_id' => $this->quizOwner->id,
            'topic_id' => $this->quizTopic->id,
        ]); // The quiz that is to be used in the tests.
        $this->deleteQuizURI .= '/' . $this->quiz->id;
        $this->myQuizzesURI = '/user/' . $this->quizOwner->id . '/quizzes';
    }

    /**
     * @test
     *
     * Ensure that a quiz can successfully be deleted.
     *
     * @return void
     */
    public function canDeleteQuiz()
    {
        $response = $this->actingAs($this->quizOwner)->delete($this->deleteQuizURI);

        // Check that the quiz no longer exists in the database.
        $this->assertDatabaseCount('quizzes', 0);

        // Check that the user is redirected to the My Quizzes page.
        $response->assertRedirect($this->myQuizzesURI);

        // Ensure that the associated quiz topic of the quiz isn't also deleted.
        $this->assertDatabaseHas('quiz_topics', [
           'topic' => $this->quizTopic->topic,
        ]);

        // TO DO - Check that the associated questions and related answers for the quiz are also deleted.
    }

    /**
     * @test
     *
     * Ensure that a quiz cannot be deleted when the current user is not the author of the quiz.
     *
     * @return void
     */
    public function cannotDeleteQuizIfNotAuthor()
    {
        $response = $this->actingAs($this->nonQuizOwner)->delete($this->deleteQuizURI);

        // Check that the quiz is still in the database.
        $this->assertDatabaseHas('quizzes', [
            'title' => $this->quiz->title,
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeURI);
    }
}
