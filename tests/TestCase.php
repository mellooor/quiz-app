<?php

namespace Tests;

use App\Models\UserRole;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var String
     *
     * The URI for the home page.
     */
    protected $homeUri = "/home";

    public function setUp(): void
    {
        parent::setUp(); // Required to include the TestCase set up code as well.

        UserRole::factory()->create(['role' => 'user']); // Regular user role is created that will be used in the tests.
        UserRole::factory()->create(['role' => 'admin']); // Administrator user role is created that will be used in the tests.
    }
}
