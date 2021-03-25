<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function adminLogin(){
        $user = factory(User::class)->create();
        Config::push('course.admin', $user->email);
        $this->actingAs($user);
    }
}
