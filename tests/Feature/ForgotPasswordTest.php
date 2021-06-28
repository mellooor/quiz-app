<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    /** @var String
     *
     * The URI for the forgot password page.
     */
    protected $uri = "/forgot-password";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensures that a forgot password email is sent if a valid email is provided.
     *
     * @return void
     */
    public function resetPasswordEmailSent()
    {
        /*
         * The from method has to be used below, otherwise the redirect goes back to
         * the home page as the HTML response redirect from Fortify is based on
         * redirecting "back" to the previous page.
         */
        $response = $this->from($this->uri)->post($this->uri, [
            'email' => $this->user->email
        ]);

        // Check that the user is redirected to the forgot password page.
        $response->assertRedirect($this->uri);

        // Check that the user is informed that the password reset link has been sent.
        $response->assertSessionHas('status');

        // Check that te password reset token has been added to the DB.
        $this->assertDatabaseHas('password_resets', [
            'email' => $this->user->email
        ]);
    }

    /**
     * @test
     *
     * Ensures that a forgot password email isn't sent if an invalid email is provided.
     *
     * @return void
     */
    public function resetPasswordEmailNotSentWithInvalidEmail()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'email' => 'invalid-email@example.com'
        ]);

        // Check that the user is redirected to the forgot password page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that nothing has been added to the password_resets table in the DB.
        $this->assertDatabaseMissing('password_resets', [
            'email' => $this->user->email
        ]);
    }
}
