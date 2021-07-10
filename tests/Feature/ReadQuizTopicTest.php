<?php

namespace Tests\Feature;

use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ReadQuizTopicTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * An administrator who is to be used in the tests.
     */
    protected $admin;

    /** @var string
     *
     * A topic which is used in the tests.
     */
    protected $topicOne;

    /** @var string
     *
     * Another topic which is used in the tests.
     */
    protected $topicTwo;

    /** @var String
     *
     * The string that is expected to be passed to the user when there are no quiz topics to display.
     */
    protected $noTopicsString = 'No topics to display';

    /** @var String
     *
     * The URI for the quiz topics page.
     */
    protected $uri = "/quiz-topics";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->admin = User::factory()->admin()->create(); // New administrator is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensure that the topics page loads as intended when only a single topic exists.
     *
     * @return void
     */
    public function canDisplaySingleTopicOnQuizTopicsPage()
    {
        $this->topicOne = QuizTopic::factory()->create(); // New topic is created.

        $response = $this->actingAs($this->admin)->get('quiz-topics');

        $response->assertSee($this->topicOne->topic);

    }

    /**
     * @test
     *
     * Ensure that the topics page loads as intended when multiple topics exist.
     *
     * @return void
     */
    public function canDisplayMultipleTopicsOnQuizTopicsPage()
    {
        // New topics are created.
        $this->topicOne = QuizTopic::factory()->create();
        $this->topicTwo = QuizTopic::factory()->create();

        $response = $this->actingAs($this->admin)->get('quiz-topics');

        $response->assertSee($this->topicOne->topic);
        $response->assertSee($this->topicTwo->topic);
    }

    /**
     * @test
     *
     * Ensure that the topics page loads as intended when no topics exist.
     *
     * @return void
     */
    public function canDisplayNoTopicsOnQuizTopicsPage()
    {
        $response = $this->actingAs($this->admin)->get('quiz-topics');

        $response->assertSee($this->noTopicsString);
    }
}
