<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\QuizTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadQuizTest extends TestCase
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

    /** @var strings
     *
     * The URI for the page that displays all of the quizzes.
     */
    protected $allQuizzesUri = "/quizzes";

    /** @var string
     *
     * The URI for the page that displays all of the quizzes by topic.
     */
    protected $topicQuizzesUri;

    /** @var string
     *
     * The  URI for the page that displays all of the quizzes by user.
     */
    protected $userQuizzesUri;

    /** @var string
     *
     * The URI for the page that displays a single quiz.
     */
    protected $individualQuizUri;

    /** @var string
     *
     * The title string used for the all quizzes page.
     */
    protected $allQuizzesTitleString = "All Quizzes";

    /** @var string
     *
     * The title string suffix used for the topic quizzes page (finalised in the set up method).
     */
    protected $topicQuizzesTitleString = " Quizzes";

    /** @var string
     *
     * The user string suffix used for the user quizzes page (finalised in the set up method).
     */
    protected $userQuizzesTitleString = "'s Quizzes";

    /** @var string
     *
     * The play button string that is used for quiz pages.
     */
    protected $playBtnString = "Play";

    /** @var string
     *
     * The edit button string that is used for quiz pages.
     */
    protected $editBtnString = "Edit";

    /** @var string
     *
     * The delete button string that is used for quiz pages.
     */
    protected $deleteBtnString = "Delete";

    /** @var string
     *
     * The heading string that is used for pagination.
     */
    protected $paginationHeadingString = "Page";

    /** @var string
     *
     * The next page indicator string that is used for pagination.
     */
    protected $paginationNextPageString = ">";

    /** @var string
     *
     * The string that is displayed on the quiz pages when there are no quizzes to display.
     */
    protected $noQuizzesString = "No Quizzes to Display";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->regularUser = User::factory()->create(); // New regular user is created who will be used in the tests.
        $this->admin = User::factory()->admin()->create(); // New administrator is created who will be used in the tests.
        $this->existingTopic = QuizTopic::factory()->create(); // New topic is created that will be used in the tests.
        $this->existingQuiz = Quiz::factory()->create(['author_id' => $this->admin->id]); // New quiz is created that will be used in the tests.
        $this->topicQuizzesUri = 'topic/' . $this->existingTopic->id . '/quizzes'; // Finalise the topic quizzes URI that will be used in some of the tests.
        $this->userQuizzesUri = 'user/' . $this->admin->id . '/quizzes'; // Finalise the user quizzes URI that will be used in some of the tests.
        $this->individualQuizUri = 'quiz/' . $this->existingQuiz->id; // Finalise the individual quiz URI that will be used in some of the tests.
        $this->topicQuizzesTitleString = $this->existingTopic->topic . $this->topicQuizzesTitleString; // Finalise the topic quizzes title string with the existing topic name.
        $this->userQuizzesTitleString = $this->admin->firstName() . $this->userQuizzesTitleString; // Finalise the user quizzes title string with the admin's first name.
    }

    /**
     * @test
     *
     * Ensure that a regular user can read all quizzes.
     *
     * @return void
     */
    public function canReadAllQuizzesAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->get($this->allQuizzesUri);

        $response->assertSee($this->allQuizzesTitleString); // Check to see if the page title can be seen on the response page.
        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
        $response->assertSee($this->playBtnString); // Check to see if the play button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that an admin can read all quizzes.
     *
     * @return void
     */
    public function canReadAllQuizzesAsAdmin()
    {
        $response = $this->actingAs($this->admin)->get($this->allQuizzesUri);

        $response->assertSee($this->allQuizzesTitleString); // Check to see if the page title can be seen on the response page.
        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
        $response->assertSee($this->playBtnString); // Check to see if the play button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the owner of a quiz can see the edit and delete action buttons on the all quizzes page.
     *
     * @return void
     */
    public function editDeleteBtnsAppearOnAllQuizzesPageForQuizOwner()
    {
        $response = $this->actingAs($this->admin)->get($this->allQuizzesUri);

        $response->assertSee($this->editBtnString); // Check to see if the edit button appears on the response page.
        $response->assertSee($this->deleteBtnString); // Check to see if the delete button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the edit and delete action buttons aren't visible for users that don't own the relevant quiz on the all quizzes page.
     *
     * @return void
     */
    public function editDeleteBtnsDontAppearOnAllQuizzesPageForNonQuizOwner()
    {
        $response = $this->actingAs($this->regularUser)->get($this->allQuizzesUri);

        $response->assertDontSee($this->editBtnString); // Check to see if the edit button doesn't appear on the response page.
        $response->assertDontSee($this->deleteBtnString); // Check to see if the delete button doesn't appear on the response page.
    }

    /**
     * @test
     *
     * Ensure that pagination works for the all quizzes page for regular users.
     *
     * @return void
     */
    public function canSeePaginationOnAllQuizzesPageAsRegularUser()
    {
        Quiz::factory(10)->create(['author_id' => $this->admin->id]); // Create more quizzes so that pagination will occur.

        $response = $this->actingAs($this->regularUser)->get($this->allQuizzesUri);

        $response->assertSee($this->paginationHeadingString); // Check to see if the pagination heading appears on the response page.
        $response->assertSee($this->paginationNextPageString, false); // Check to see if the next page indicator appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that pagination works for the all quizzes page for admins.
     *
     * @return void
     */
    public function canSeePaginationOnAllQuizzesPageAsAdmin()
    {
        Quiz::factory(10)->create(['author_id' => $this->admin->id]); // Create more quizzes so that pagination will occur.

        $response = $this->actingAs($this->admin)->get($this->allQuizzesUri);

        $response->assertSee($this->paginationHeadingString); // Check to see if the pagination heading appears on the response page.
        $response->assertSee($this->paginationNextPageString, false); // Check to see if the next page indicator appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the all quizzes page loads as intended for regular users if there are no quizzes to display.
     *
     * @return void
     */
    public function canDisplayNoQuizzesOnAllQuizzesPageForRegularUser()
    {
        $this->existingQuiz->delete(); // Delete the existing quiz so that there are none remaining for the test.

        $response = $this->actingAs($this->regularUser)->get($this->allQuizzesUri);

        $response->assertSee($this->noQuizzesString); // Check to see if the pagination heading appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the all quizzes page loads as intended for admins if there are no quizzes to display.
     *
     * @return void
     */
    public function canDisplayNoQuizzesOnAllQuizzesPageForAdmin()
    {
        $this->existingQuiz->delete(); // Delete the existing quiz so that there are none remaining for the test.

        $response = $this->actingAs($this->admin)->get($this->allQuizzesUri);

        $response->assertSee($this->noQuizzesString); // Check to see if the pagination heading appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that regular users can read all quizzes when filtered by topic.
     *
     * @return void
     */
    public function canReadAllQuizzesByTopicAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->get($this->topicQuizzesUri);

        $response->assertSee($this->topicQuizzesTitleString); // Check to see if the page title can be seen on the response page.
        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
        $response->assertSee($this->playBtnString); // Check to see if the play button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that admins can read all quizzes when filtered by topic.
     *
     * @return void
     */
    public function canReadAllQuizzesByTopicAsAdmin()
    {
        $response = $this->actingAs($this->admin)->get($this->topicQuizzesUri);

        $response->assertSee($this->topicQuizzesTitleString); // Check to see if the page title can be seen on the response page.
        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
        $response->assertSee($this->playBtnString); // Check to see if the play button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the owner of a quiz can see the edit and delete action buttons on the quizzes by topic page.
     *
     * @return void
     */
    public function editDeleteBtnsAppearOnByTopicPageForQuizOwner()
    {
        $response = $this->actingAs($this->admin)->get($this->topicQuizzesUri);

        $response->assertSee($this->editBtnString); // Check to see if the edit button appears on the response page.
        $response->assertSee($this->deleteBtnString); // Check to see if the delete button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the edit and delete action buttons aren't visible for users that don't own the relevant quiz on the quizzes by topic page.
     *
     * @return void
     */
    public function editDeleteBtnsDontAppearOnByTopicPageForNonQuizOwner()
    {
        $response = $this->actingAs($this->regularUser)->get($this->topicQuizzesUri);

        $response->assertDontSee($this->editBtnString); // Check to see if the edit button doesn't appear on the response page.
        $response->assertDontSee($this->deleteBtnString); // Check to see if the delete button doesn't appear on the response page.
    }

    /**
     * @test
     *
     * Ensure that pagination works for the quizzes by topic page for regular users.
     *
     * @return void
     */
    public function canSeePaginationOnByTopicPageAsRegularUser()
    {
        Quiz::factory(10)->create(['author_id' => $this->admin->id]); // Create more quizzes so that pagination will occur.

        $response = $this->actingAs($this->regularUser)->get($this->topicQuizzesUri);

        $response->assertSee($this->paginationHeadingString); // Check to see if the pagination heading appears on the response page.
        $response->assertSee($this->paginationNextPageString, false); // Check to see if the next page indicator appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that pagination works for the quizzes by topic page for admins.
     *
     * @return void
     */
    public function canSeePaginationOnByTopicPageAsAdmin()
    {
        Quiz::factory(10)->create(['author_id' => $this->admin->id]); // Create more quizzes so that pagination will occur.

        $response = $this->actingAs($this->admin)->get($this->topicQuizzesUri);

        $response->assertSee($this->paginationHeadingString); // Check to see if the pagination heading appears on the response page.
        $response->assertSee($this->paginationNextPageString, false); // Check to see if the next page indicator appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the quizzes by topic page loads as intended for regular users if there are no quizzes to display.
     *
     * @return void
     */
    public function canDisplayNoQuizzesOnByTopicPageForRegularUser()
    {
        $this->existingQuiz->delete(); // Delete the existing quiz so that there are none remaining for the test.

        $response = $this->actingAs($this->regularUser)->get($this->topicQuizzesUri);

        $response->assertSee($this->noQuizzesString); // Check to see if the pagination heading appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the quizzes by topic page loads as intended for admins if there are no quizzes to display.
     *
     * @return void
     */
    public function canDisplayNoQuizzesOnByTopicPageForAdmin()
    {
        $this->existingQuiz->delete(); // Delete the existing quiz so that there are none remaining for the test.

        $response = $this->actingAs($this->admin)->get($this->topicQuizzesUri);

        $response->assertSee($this->noQuizzesString); // Check to see if the pagination heading appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that regular users can read all quizzes when filtered by user.
     *
     * @return void
     */
    public function canReadAllQuizzesByUserAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->get($this->allQuizzesUri);

        $response->assertSee($this->allQuizzesTitleString); // Check to see if the page title can be seen on the response page.
        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
        $response->assertSee($this->playBtnString); // Check to see if the play button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that admins can read all quizzes when filtered by user.
     *
     * @return void
     */
    public function canReadAllQuizzesByUserAsAdmin()
    {
        $response = $this->actingAs($this->admin)->get($this->allQuizzesUri);

        $response->assertSee($this->allQuizzesTitleString); // Check to see if the page title can be seen on the response page.
        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
        $response->assertSee($this->playBtnString); // Check to see if the play button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the owner of a quiz can see the edit and delete action buttons on the quizzes by user page.
     *
     * @return void
     */
    public function editDeleteBtnsAppearOnByUserPageForQuizOwner()
    {
        $response = $this->actingAs($this->admin)->get($this->userQuizzesUri);

        $response->assertSee($this->editBtnString); // Check to see if the edit button appears on the response page.
        $response->assertSee($this->deleteBtnString); // Check to see if the delete button appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the edit and delete action buttons aren't visible for users that don't own the relevant quiz on the quizzes by user page.
     *
     * @return void
     */
    public function editDeleteBtnsDontAppearOnByUserPageForNonQuizOwner()
    {
        $response = $this->actingAs($this->regularUser)->get($this->userQuizzesUri);

        $response->assertDontSee($this->editBtnString); // Check to see if the edit button doesn't appear on the response page.
        $response->assertDontSee($this->deleteBtnString); // Check to see if the delete button doesn't appear on the response page.
    }

    /**
     * @test
     *
     * Ensure that pagination works for the quizzes by user page for regular users.
     *
     * @return void
     */
    public function canSeePaginationOnByUserPageAsRegularUser()
    {
        Quiz::factory(10)->create(['author_id' => $this->admin->id]); // Create more quizzes so that pagination will occur.

        $response = $this->actingAs($this->regularUser)->get($this->userQuizzesUri);

        $response->assertSee($this->paginationHeadingString); // Check to see if the pagination heading appears on the response page.
        $response->assertSee($this->paginationNextPageString, false); // Check to see if the next page indicator appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that pagination works for the quizzes by user page for admins.
     *
     * @return void
     */
    public function canSeePaginationOnByUserPageAsAdmin()
    {
        Quiz::factory(10)->create(['author_id' => $this->admin->id]); // Create more quizzes so that pagination will occur.

        $response = $this->actingAs($this->admin)->get($this->userQuizzesUri);

        $response->assertSee($this->paginationHeadingString); // Check to see if the pagination heading appears on the response page.
        $response->assertSee($this->paginationNextPageString, false); // Check to see if the next page indicator appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the quizzes by user page loads as intended for regular users if there are no quizzes to display.
     *
     * @return void
     */
    public function canDisplayNoQuizzesOnByUserPageForRegularUser()
    {
        $this->existingQuiz->delete(); // Delete the existing quiz so that there are none remaining for the test.

        $response = $this->actingAs($this->regularUser)->get($this->userQuizzesUri);

        $response->assertSee($this->noQuizzesString); // Check to see if the pagination heading appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that the quizzes by topic page loads as intended for admins if there are no quizzes to display.
     *
     * @return void
     */
    public function canDisplayNoQuizzesOnByUserPageForAdmin()
    {
        $this->existingQuiz->delete(); // Delete the existing quiz so that there are none remaining for the test.

        $response = $this->actingAs($this->admin)->get($this->userQuizzesUri);

        $response->assertSee($this->noQuizzesString); // Check to see if the pagination heading appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that regular users can read a single quiz.
     *
     * @return void
     */
    public function canReadSingleQuizAsRegularUser()
    {
        $response = $this->actingAs($this->regularUser)->get($this->individualQuizUri);

        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
    }

    /**
     * @test
     *
     * Ensure that admins can read a single quiz.
     *
     * @return void
     */
    public function canReadSingleQuizAsAdmin()
    {
        $response = $this->actingAs($this->admin)->get($this->individualQuizUri);

        $response->assertSee($this->existingQuiz->title); // Check to see if the existing quiz title appears on the response page.
    }
}
