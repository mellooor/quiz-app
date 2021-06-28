<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensures that users can be deleted from the app.
     *
     * @return void
     */
    public function canDeleteUser()
    {
        $response = $this->actingAs($this->user)->from($this->homeUri)->delete('/user');

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that the user doesn't exist in the database.
        $this->assertDatabaseCount('users', 0);
    }
}
