<?php

namespace Tests\Feature;

use App\Mail\ConfirmYourEmail;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_register_successful()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('register', [
           'name' => 'huy nguyen',
           'email' => 'huy@gmail.com',
           'password' => 'password',
           'password_confirmation' => 'password'
        ]);

        $response->assertRedirect()->assertStatus(302);
        $this->assertDatabaseHas('users', [
           'username' => \Str::slug('huy nguyen')
        ]);
    }

    public function test_sent_mail_confirm_new_user(){
        $this->withoutExceptionHandling();
        Mail::fake();
        $response = $this->post('register', [
            'name' => 'huy nguyen',
            'email' => 'huy@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertRedirect()->assertStatus(302);
        Mail::assertQueued(ConfirmYourEmail::class);
    }

    public function test_user_get_confirm_token_after_register(){
        $this->withoutExceptionHandling();
        Mail::fake();
        $response = $this->post('register', [
            'name' => 'huy nguyen',
            'email' => 'huy@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $user = User::find(1);
       $this->assertNotNull($user->confirm_token);
       $this->assertFalse($user->isConfirm());
    }

    /**
     *
     */
    public function test_user_can_confirm_email(){
        $this->withoutExceptionHandling();
        Mail::fake();
        $response = $this->post('register', [
            'name' => 'huy nguyen',
            'email' => 'huy@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $user = User::find(1);
        $res = $this->get("/register/confirm?token=$user->confirm_token");
        $res->assertRedirect('/')->assertSessionHas('success', 'Your email has been confirmed.');
        $user->refresh();
        $this->assertTrue($user->isConfirm());

    }

    public function test_user_is_redirected_if_token_wrong(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $res = $this->get("/register/confirm?token=wrong-token");
        $res->assertRedirect('wrong-token')->assertSessionHas('fail', "Your email hasn't been confirmed.");
    }
}
