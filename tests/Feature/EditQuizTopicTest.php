<?php

namespace Tests\Feature;

use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditQuizTopicTest extends TestCase
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

    /** @var \App\Models\QuizTopic
     *
     * An existing topic which is used in the tests.
     */
    protected $existingTopic;

    /** @var string
     *
     * The name that is used for the existing topic.
     */
    protected $existingTopicName = 'Existing Topic';

    /** @var string
     *
     * A non-existing topic which is used in the tests.
     */
    protected $topic = 'Example Topic';

    /** @var String
     *
     * The URI for the quiz topics page.
     */
    protected $uri = "/quiz-topic";

    /** @var String
     *
     * The full URI for the quiz topics page PUT requests.
     */
    protected $uriWithTopicID;

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->regularUser = User::factory()->create(); // New regular user is created who will be used in the tests.
        $this->admin = User::factory()->admin()->create(); // New administrator is created who will be used in the tests.
        $this->existingTopic = QuizTopic::factory()->create(['topic' => $this->existingTopicName]); // New topic is created that will be used in the tests.
        $this->uriWithTopicID = $this->uri . '/' . $this->existingTopic->id;
    }

    /**
     * @test
     *
     * Ensure that an admin can edit quiz topics.
     *
     * @return void
     */
    public function canEditAQuizTopic()
    {
        $response = $this->actingAs($this->admin)->from($this->uri)->put($this->uriWithTopicID, [
            'topic' => $this->topic,
        ]);

        // Check that the quiz topic has been added to the DB.
        $this->assertDatabaseHas('quiz_topics', [
            'topic' => $this->topic,
        ]);

        // Check that the user is redirected to the quiz topics page.
        $response->assertRedirect($this->uri);
    }

    /**
     * @test
     *
     * Ensure that a regular user cannot edit quiz topics.
     *
     * @return void
     */
    public function cannotEditAQuizTopicAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->from($this->uri)->put($this->uriWithTopicID, [
            'topic' => $this->topic,
        ]);

        // Check that the user has been added to the DB.
        $this->assertDatabaseMissing('quiz_topics', [
            'topic' => $this->topic,
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect('home');
    }

    /**
     * @test
     *
     * Ensure that a quiz topic cannot be edited to a different topic if that topic already exists
     * (both topics are identical in letter casing).
     *
     * @return void
     */
    public function cannotChangeToAnExistingQuizTopicMatchingCase()
    {
        $response = $this->actingAs($this->admin)->from($this->uri)->put($this->uriWithTopicID, [
            'topic' => $this->existingTopicName,
        ]);

        // Check that there is no duplicate topic in the DB.
        $this->assertDatabaseCount('quiz_topics', 1);

        // Check that the user is redirected to the quiz topics page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }

    /**
     * @test
     *
     * Ensure that a quiz topic cannot be edited to a different topic if that topic already exists
     * (each topic has different letter casing).
     *
     * @return void
     */
    public function cannotChangeToAnExistingQuizTopicNonMatchingCase()
    {
        $response = $this->actingAs($this->admin)->from($this->uri)->put($this->uriWithTopicID, [
            'topic' => strtoupper($this->existingTopicName), // The existing topic name but in all caps.
        ]);

        // Check that there is no duplicate topic in the DB.
        $this->assertDatabaseCount('quiz_topics', 1);

        // Check that the user is redirected to the quiz topics page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();
    }
}
