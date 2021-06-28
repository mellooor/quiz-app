<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    /** @var String
     *
     * The URI for the logout page.
     */
    protected $uri = "/logout";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensure that a user can log out from the app.
     *
     * @return void
     */
    public function userCanLogOut()
    {
        $response = $this->actingAs($this->user)->from($this->uri)->post($this->uri);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that the user is logged out.
        $this->assertFalse(Auth::check());
    }
}
