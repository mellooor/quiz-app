<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditQuizTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * An administrator who is to be used in the tests.
     */
    protected $adminOne;

    /** @var \App\Models\User
     *
     * Another administrator who is to be used in the tests.
     */
    protected $adminTwo;

    /** @var string
     *
     * A quiz title which is used in some of the tests.
     */
    protected $quizTitle = 'Quiz Title';

    /** @var \App\Models\Quiz
     *
     * An existing quiz which is used in the tests.
     */
    protected $existingQuizOne;

    /** @var \App\Models\Quiz
     *
     * Another existing quiz which is used in the tests.
     */
    protected $existingQuizTwo;

    /** @var \App\Models\QuizTopic
     *
     * An existing topic which is used in the tests.
     */
    protected $existingTopicOne;

    /** @var \App\Models\QuizTopic
     *
     * Another existing topic which is used in the tests.
     */
    protected $existingTopicTwo;

    /** @var string
     *
     * The URI for the edit quiz page (ID of quiz one is suffixed to the string in the set up method).
     */
    protected $editQuizOneUri = "/edit-quiz/";

    /** @var string
     *
     * The URI for the home page.
     */
    protected $homeUri = "/home";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->adminOne = User::factory()->admin()->create(); // New administrator is created who will be used in the tests.
        $this->adminTwo = User::factory()->admin()->create(); // Another new administrator is created who will be used in the tests.
        $this->existingTopicOne = QuizTopic::factory()->create(); // New topic is created that will be used in the tests.
        $this->existingTopicTwo = QuizTopic::factory()->create(); // Another new topic is created that will be used in the tests.
        $this->existingQuizOne = Quiz::factory()->create([
            'author_id' => $this->adminOne->id,
            'topic_id' => $this->existingTopicOne->id,
        ]); // New quiz is created that will be used in the tests.
        $this->existingQuizTwo = Quiz::factory()->create(['author_id' => $this->adminOne->id]); // Another new quiz is created that will be used in the tests.

        $this->editQuizOneUri .= $this->existingQuizOne->id; // The ID of the existing quiz is suffixed to the edit quiz URI.
    }

    /**
     * @test
     *
     * Ensure that a user can edit their own quiz.
     *
     * @return void
     */
    public function userCanEditTheirOwnQuiz()
    {
        $response = $this->actingAs($this->adminOne)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => $this->existingTopicTwo->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has been updated in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => $this->existingTopicTwo->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the user is redirected to the quiz edit page.
        $response->assertRedirect($this->editQuizOneUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * @test
     *
     * Ensure that a user cannot edit a quiz that doesn't belong to them.
     *
     * @return void
     */
    public function cannotEditOtherUsersQuiz()
    {
        $response = $this->actingAs($this->adminTwo)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => $this->existingTopicTwo->id,
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz is unchanged in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => $this->existingQuizOne->topic_id,
            'title' => $this->existingQuizOne->title,
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);
    }

    /**
     * @test
     *
     * Ensure that a user can edit just the title of their quiz.
     *
     * @return void
     */
    public function canEditQuizTitleOnly()
    {
        $response = $this->actingAs($this->adminOne)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => $this->existingQuizOne->topic_id, // topic_id is unchanged.
            'title' => $this->quizTitle,
        ]);

        // Check that the quiz has been updated in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => $this->existingQuizOne->topic_id,
            'title' => $this->quizTitle,
        ]);

        // Check that the user is redirected to the quiz edit page.
        $response->assertRedirect($this->editQuizOneUri);

        // Check that no validation errors have been provided in the redirect.
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * @test
     *
     * Ensure that a user can edit just the topic of their quiz.
     *
     * @return void
     */
    public function canEditTopicOnly()
    {
        $response = $this->actingAs($this->adminOne)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => $this->existingTopicTwo->id,
            'title' => $this->existingQuizOne->title, // title is unchanged.
        ]);

        // Check that the quiz has been updated in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => $this->existingTopicTwo->id,
            'title' => $this->existingQuizOne->title,
        ]);

        // Check that the user is redirected to the quiz edit page.
        $response->assertRedirect($this->editQuizOneUri);

        // Check that no validation errors have been provided in the redirect.
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * @test
     *
     * Ensure that a user can edit the topic of their quiz to none.
     *
     * @return void
     */
    public function canEditTopicToNone()
    {
        $response = $this->actingAs($this->adminOne)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => '',
            'title' => $this->existingQuizOne->title, // title is unchanged.
        ]);

        // Check that the quiz has been updated in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => null,
            'title' => $this->existingQuizOne->title,
        ]);

        // Check that the user is redirected to the quiz edit page.
        $response->assertRedirect($this->editQuizOneUri);

        // Check that no validation errors have been provided in the redirect.
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * @test
     *
     * Ensure that a user cannot edit the title of their quiz to a title that's already taken (both titles are identical in letter casing).
     *
     * @return void
     */
    public function cannotEditQuizTitleToExistingTitleMatchingCase()
    {
        $response = $this->actingAs($this->adminOne)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => $this->existingQuizOne->topic_id, // topic_id is unchanged.
            'title' => $this->existingQuizTwo->title,
        ]);

        // Check that the quiz is unchanged in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => $this->existingQuizOne->topic_id,
            'title' => $this->existingQuizOne->title,
        ]);

        // Check that the user is redirected to the quiz edit page.
        $response->assertRedirect($this->editQuizOneUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }

    /**
     * @test
     *
     * Ensure that a user cannot edit the title of their quiz to a title that's already taken (each title has different letter casing).
     *
     * @return void
     */
    public function cannotEditQuizTitleToExistingTitleNonMatchingCase()
    {
        $response = $this->actingAs($this->adminOne)->from($this->editQuizOneUri)->put($this->editQuizOneUri, [
            'topic_id' => $this->existingQuizOne->topic_id, // topic_id is unchanged.
            'title' => strtoupper($this->existingQuizTwo->title),
        ]);

        // Check that the quiz is unchanged in the DB.
        $this->assertDatabaseHas('quizzes', [
            'topic_id' => $this->existingQuizOne->topic_id,
            'title' => $this->existingQuizOne->title,
        ]);

        // Check that the user is redirected to the quiz edit page.
        $response->assertRedirect($this->editQuizOneUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }
}
