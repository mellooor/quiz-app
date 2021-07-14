<?php

namespace Tests\Feature;

use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteQuizTopicTest extends TestCase
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

    /** @var String
     *
     * The URI for the quiz topics page.
     */
    protected $uri = "/quiz-topic";

    /** @var String
     *
     * The full URI for the quiz topics page DELETE requests.
     */
    protected $uriWithTopicID;

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->regularUser = User::factory()->create(); // New regular user is created who will be used in the tests.
        $this->admin = User::factory()->admin()->create(); // New administrator is created who will be used in the tests.
        $this->existingTopic = QuizTopic::factory()->create(); // New topic is created that will be used in the tests.
        $this->uriWithTopicID = $this->uri . '/' . $this->existingTopic->id;
    }

    /**
     * @test
     *
     * Ensure that an admin can delete quiz topics.
     *
     * @return void
     */
    public function canDeleteAQuizTopic()
    {
        $response = $this->actingAs($this->admin)->from($this->uri)->delete($this->uriWithTopicID);

        // Check that the quiz topic no longer exists in the database.
        $this->assertDatabaseCount('quiz_topics', 0);

        // Check that the user is redirected to the quiz topics page.
        $response->assertRedirect($this->uri);
    }

    /**
     * @test
     *
     * Ensure that a regular user cannot delete quiz topics.
     *
     * @return void
     */
    public function cannotDeleteAQuizTopicAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->from($this->uri)->delete($this->uriWithTopicID);

        // Check that the quiz topic is still present in the DB.
        $this->assertDatabaseHas('quiz_topics', [
            'topic' => $this->existingTopic->topic,
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect('home');
    }
}
