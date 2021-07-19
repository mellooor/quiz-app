<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateQuizTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * A regular user who is to be used in the tests.
     */
    protected $regularUser;

    /** @var \App\Models\User
     *
     * An administrator who is to be used in the tests.
     */
    protected $admin;

    /** @var string
     *
     * A quiz title which is used in the canCreateQuiz test.
     */
    protected $quizTitle = 'Quiz Title';

    /** @var int
     *
     * The maximum number of questions that are allowed for a quiz.
     */
    protected $maxQuestions = 10;

    /** @var \App\Models\Quiz
     *
     * An existing quiz which is used in the tests.
     */
    protected $existingQuiz;

    /** @var \App\Models\QuizTopic
     *
     * An existing topic which is used in the tests.
     */
    protected $existingTopic;

    /** @var string
     *
     * A non-existing topic which is used in the tests.
     */
    protected $topic = 'Example Topic';

    /** @var string
     *
     * The URI for the create a quiz page.
     */
    protected $createQuizUri = "/new-quiz";

    /** @var string
     *
     * The URI for the quiz questions page.
     */
    protected $quizQuestionsUri = "/questions";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->regularUser = User::factory()->create(); // New regular user is created who will be used in the tests.
        $this->admin = User::factory()->admin()->create(); // New administrator is created who will be used in the tests.
        $this->existingTopic = QuizTopic::factory()->create(); // New topic is created that will be used in the tests.
        $this->existingQuiz = Quiz::factory()->create(); // New quiz is created that will be used in the tests.
    }

    /**
     * @test
     *
     * Ensure that an admin can create quizzes.
     *
     * @return void
     */
    public function canCreateAQuiz()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has been added to the DB.
        $this->assertDatabaseHas('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Retrieve the model of the quiz that was just created (ID to be used in the redirect URI parameter below.
        $newQuiz = Quiz::orderBy('id', 'desc')->first();

        // Check that the user is redirected to the quiz questions page (ID of the new quiz included).
        $response->assertRedirect($newQuiz->id . $this->quizQuestionsUri);
    }

    /**
     * @test
     *
     * Ensure that quizzes can be created without a quiz topic value.
     *
     * @return void
     */
    public function canCreateAQuizWithoutQuizTopic()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => '',
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz topic has been added to the DB.
        $this->assertDatabaseHas('quizzes', [
            'author_id' => $this->admin->id,
            'title' => $this->quizTitle,
        ]);

        // Retrieve the model of the quiz that was just created (ID to be used in the redirect URI parameter below.
        $newQuiz = Quiz::orderBy('id', 'desc')->first();

        // Check that the user is redirected to the quiz questions page (ID of the new quiz included).
        $response->assertRedirect($newQuiz->id . $this->quizQuestionsUri);
    }

    /**
     * @test
     *
     * Ensure that a regular user cannot create quizzes.
     *
     * @return void
     */
    public function cannotCreateAQuizAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has not been added to the DB.
        $this->assertDatabaseMissing('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect('home');
    }

    /**
     * @test
     *
     * Ensure that a non-existing user cannot create quizzes.
     *
     * @return void
     */
    public function cannotCreateAQuizAsNonUser()
    {
        $response = $this->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has not been added to the DB.
        $this->assertDatabaseMissing('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect('login');
    }

    /**
     * @test
     *
     * Ensure that a quiz cannot be created if it already exists (both quizzes are identical in letter casing).
     *
     * @return void
     */
    public function cannotCreateAnExistingQuizMatchingCase()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->existingQuiz->title,
        ]);

        // Check that there is no duplicate quiz in the DB.
        $this->assertDatabaseCount('quizzes', 1);

        // Check that the user is redirected to the create a quiz page.
        $response->assertRedirect($this->createQuizUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }

    /**
     * @test
     *
     * Ensure that a quiz cannot be created if it already exists (each quiz has different letter casing).
     *
     * @return void
     */
    public function cannotCreateAnExistingQuizNonMatchingCase()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => strtoupper($this->existingQuiz->title), // The existing quiz name but in all caps.
        ]);

        // Check that there is no duplicate quiz in the DB.
        $this->assertDatabaseCount('quizzes', 1);

        // Check that the user is redirected to the create a quiz page.
        $response->assertRedirect($this->createQuizUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }

    /**
     * @test
     *
     * Ensure that a quiz cannot be created if the supplied topic name doesn't match any existing topics in the DB.
     *
     * @return void
     */
    public function cannotCreateQuizWithInvalidTopic()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => 100,
            'title' => $this->quizTitle,
        ]);

        // Check that there is no duplicate quiz in the DB.
        $this->assertDatabaseCount('quizzes', 1);

        // Check that the user is redirected to the create a quiz page.
        $response->assertRedirect($this->createQuizUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }

    /**
     * @test
     *
     * Ensure that a quiz is deleted if the author user is deleted.
     *
     * @return void
     */
    public function quizDeletedWithUser()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has not been added to the DB.
        $this->assertDatabaseHas('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        $this->admin->delete();

        // Check that the quiz has not been added to the DB.
        $this->assertDatabaseMissing('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);
    }

    /**
     * @test
     *
     * Ensure that a quiz's topic id value is set to null if the related topic is deleted.
     *
     * @return void
     */
    public function quizTopicIdNullIfTopicDeleted()
    {
        $response = $this->actingAs($this->admin)->from($this->createQuizUri)->post($this->createQuizUri, [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has not been added to the DB.
        $this->assertDatabaseHas('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => $this->existingTopic->id,
            'title' => $this->quizTitle,
        ]);

        $this->existingTopic->delete();

        // Check that the quiz has not been added to the DB.
        $this->assertDatabaseMissing('quizzes', [
            'author_id' => $this->admin->id,
            'topic_id' => '',
            'title' => $this->quizTitle,
        ]);
    }
}
