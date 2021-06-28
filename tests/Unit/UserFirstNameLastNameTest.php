<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFirstNameLastNameTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User
     *
     * User who is to be used in the tests.
     */
    protected $user;

    /** @var string
     *
     * The first name that is to be used in the tests.
     */
    protected $firstName = 'Peter';

    /** @var string
     *
     * The last names that are to be used in the tests.
     */
    protected $lastNames = 'Peterson Peterington';

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        $this->user = User::factory()->create(['name' => $this->firstName . " " . $this->lastNames]); // New user is created who will be used in the tests.
    }

    /**
     * @test
     *
     * Ensures that the user's first name is correctly returned.
     *
     * @return void
     */
    public function firstNameIsCorrect()
    {
        $this->assertEquals($this->firstName, $this->user->firstName());
    }

    /**
     * @test
     *
     * Ensures that the user's last names are correctly returned.
     *
     * @return void
     */
    public function lastNamesAreCorrect()
    {
        $this->assertEquals($this->lastNames, $this->user->lastNames());
    }
}
