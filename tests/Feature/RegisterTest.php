<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @var string
     *
     * A name which is used in the tests.
     */
    protected $name = 'Example Examplerson';

    /** @var string
     *
     * An email address which is used in the tests.
     */
    protected $email = 'example@example.com';

    /** @var string
     *
     * A password which is used in the tests.
     */
    protected $password = 'password';

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    /** @var String
     *
     * The URI for the register page.
     */
    protected $uri = "/register";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensure that a user can register an account with the app.
     *
     * @return void
     */
    public function canCreateAnAccount()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        // Check that the user has been added to the DB.
        $this->assertDatabaseHas('users', [
            'name' => $this->name,
            'email' => $this->email
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that the user is logged in.
        $this->assertTrue(Auth::check());
    }

    /**
     * @test
     *
     * Ensure that a user account isn't registered when the supplied passwords don't match.
     *
     * @return void
     */
    public function cannotCreateAnAccountWhenPasswordsNotMatching()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'name' => 'Example Examplerson',
            'email' => 'example@example.com',
            'password' => 'password',
            'password_confirmation' => 'different password'
        ]);

        // Check that the user is redirected to the register page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user isn't logged in.
        $this->assertFalse(Auth::check());
    }

    /**
     * @test
     *
     * Ensure that a user cannot register an account with the application if the provided
     * email address is already in use.
     *
     * @return void
     */
    public function cannotCreateAnAccountWithExistingEmailAddress()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'password_confirmation' => $this->user->password
        ]);

        // Check that the user is redirected to the register page.
        $response->assertRedirect($this->uri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user isn't logged in.
        $this->assertFalse(Auth::check());
    }

    /**
     * @test
     *
     * Ensure that a registered user doesn't have administrator privileges by default.
     *
     * @return void
     */
    public function registeredUserIsNotAdminByDefault()
    {
        $response = $this->from($this->uri)->post($this->uri, [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        // Check that the user isn't an administrator.
        $this->assertFalse(Auth::user()->isAdmin());
    }
}
