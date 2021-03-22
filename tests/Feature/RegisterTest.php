<?php

namespace Tests\Feature;

use App\Mail\ConfirmYourEmail;
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
        Mail::assertSent(ConfirmYourEmail::class);
    }
}
