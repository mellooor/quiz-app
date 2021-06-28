<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    /** @var string
     *
     * The old password that is to be used in the tests.
     */
    protected $oldPassword = 'password';

    /** @var string
     *
     * The new password that is to be used in the tests.
     */
    protected $newPassword = 'password123';

    /** @var String
     *
     * The URI for the reset password page.
     */
    protected $uri = "/reset-password";

    /** @var String
     *
     * The URI for the login page.
     */
    protected $loginUri = "/login";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensures that a user can reset their password.
     *
     * @return void
     */
    public function passwordIsReset()
    {
        $token = Password::broker()->createToken($this->user);

        $response = $this->from($this->uri)->post($this->uri, [
           'token' => $token,
           'email' => $this->user->email,
           'password' => $this->newPassword,
           'password_confirmation' => $this->newPassword
        ]);

        // Check that the user is redirected to the login page.
        $response->assertRedirect($this->loginUri);

        // Check that the user's password has been updated to the new password.
        $this->user->refresh();
        $this->assertTrue(Hash::check($this->newPassword, $this->user->password));
    }

    /**
     * @test
     *
     * Ensures that a password isn't reset if the supplied token is incorrect.
     *
     * @return void
     */
    public function passwordNotResetWithInvalidToken()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'token' => 'invalid_token',
            'email' => $this->user->email,
            'password' => $this->newPassword,
            'password_confirmation' => $this->newPassword
        ]);

        // Check that the user is redirected to the forgot password page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user's password is unchanged.
        $this->assertTrue(Hash::check($this->oldPassword, $this->user->password));
    }

    /**
     * @test
     *
     * Ensures that a password isn't reset if the supplied email is invalid.
     *
     * @return void
     */
    public function passwordNotResetWhenEmailInvalid()
    {
        $token = Password::broker()->createToken($this->user);

        $response = $this->from($this->uri)->post($this->uri, [
            'token' => $token,
            'email' => 'invalid-email@example.com',
            'password' => $this->newPassword,
            'password_confirmation' => $this->newPassword
        ]);

        // Check that the user is redirected to the forgot password page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user's password is unchanged.
        $this->assertTrue(Hash::check($this->oldPassword, $this->user->password));
    }

    /**
     * @test
     *
     * Ensures that a password isn't reset if the supplied passwords don't match
     *
     * @return void
     */
    public function passwordNotResetWhenPasswordsNotMatching()
    {
        $token = Password::broker()->createToken($this->user);

        $response = $this->from($this->uri)->post($this->uri, [
            'token' => $token,
            'email' => $this->user->email,
            'password' => $this->newPassword,
            'password_confirmation' => 'different password'
        ]);

        // Check that the user is redirected to the forgot password page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user's password is unchanged.
        $this->assertTrue(Hash::check($this->oldPassword, $this->user->password));
    }
}
