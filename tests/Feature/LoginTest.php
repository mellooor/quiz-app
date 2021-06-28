<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    /** @var String
     *
     * The URI for the login page.
     */
    protected $uri = "/login";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensures that users can log into the app.
     *
     * @return void
     */
    public function canLogIn()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that the user is logged in.
        $this->assertTrue(Auth::check());
    }

    /**
     * @test
     *
     * Ensures that users cannot log into the app with the incorrect credentials.
     *
     * @return void
     */
    public function cannotLogInWithIncorrectCredentials()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'email' => $this->user->email,
            'password' => 'wrong-password'
        ]);

        // Check that the user is redirected to the login page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user is logged in.
        $this->assertFalse(Auth::check());
    }
}
