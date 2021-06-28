<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserDetailsTest extends TestCase
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
    protected $uri = "/user/profile-information";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensures that users can update their name on the app.
     *
     * @return void
     */
    public function canUpdateName()
    {
        $newName = 'New Nameson';

        $response = $this->actingAs($this->user)->from($this->homeUri)->put($this->uri, [
            'name' => $newName,
            'email' => $this->user->email
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that the user's email address has been updated.
        $this->user->refresh();
        $this->assertTrue($this->user->name === $newName);
    }

    /**
     * @test
     *
     * Ensures that users cannot update their name on the app if the email
     * address field on the update profile form is left blank.
     *
     * @return void
     */
    public function cannotUpdateNameIfEmailAddressFieldBlank()
    {
        $newName = 'New Nameson';

        $response = $this->actingAs($this->user)->from($this->homeUri)->put($this->uri, [
            'name' => $newName,
            'email' => ''
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user's email address hasn't been updated.
        $this->user->refresh();
        $this->assertTrue($this->user->name !== $newName);
    }

    /**
     * @test
     *
     * Ensures that users can update their email address on the app.
     *
     * @return void
     */
    public function canUpdateEmailAddress()
    {
        $newEmailAddress = 'new-email-address@example.com';

        $response = $this->actingAs($this->user)->from($this->homeUri)->put($this->uri, [
            'name' => $this->user->name,
            'email' => $newEmailAddress
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that the user's email address has been updated.
        $this->user->refresh();
        $this->assertTrue($this->user->email === $newEmailAddress);
    }

    /**
     * @test
     *
     * Ensures that users cannot update their email address on the app if
     * the name field on the update profile form is left blank.
     *
     * @return void
     */
    public function cannotUpdateEmailAddressIfNameFieldBlank()
    {
        $newEmailAddress = 'new-email-address@example.com';

        $response = $this->actingAs($this->user)->from($this->homeUri)->put($this->uri, [
            'name' => '',
            'email' => $newEmailAddress
        ]);

        // Check that the user is redirected to the home page.
        $response->assertRedirect($this->homeUri);

        // Check that validation errors have been provided in the redirect.
        $response->assertSessionHasErrors();

        // Check that the user's email address hasn't been updated.
        $this->user->refresh();
        $this->assertTrue($this->user->email !== $newEmailAddress);
    }
}
