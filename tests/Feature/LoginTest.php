<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_input_wrong_password_return_correct_message()
    {
        $user = factory(User::class)->create();
       $res =  $this->postJson('login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);
        $res->assertStatus(422);
        $res->assertJson([
            'errors' => [
                'email' => [
                    "These credentials do not match our records."
                ]
            ],
            'message'=> "The given data was invalid."
        ]);

    }
    public function test_user_input_correct_password_return_correct_message()
    {
        $user = factory(User::class)->create();
        $res =  $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $res->assertRedirect();
//        $res->assertJson([
//                'status' => 'ok'
//        ])->assertSessionHas('success', 'Login successfully!');

    }

}
