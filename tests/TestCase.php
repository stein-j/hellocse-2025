<?php

namespace Tests;

use App\Models\Admin;
use Database\Factories\AdminFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function createAdmin(): Admin
    {
        return AdminFactory::new()->create();
    }
}
