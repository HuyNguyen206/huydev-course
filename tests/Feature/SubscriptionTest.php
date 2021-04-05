<?php

namespace Tests\Feature;

use App\Model\Lesson;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function fakeSubscribe($user)
    {
        $user->subscriptions()->create([
            'name' => 'default',
            'stripe_id' => 'fake_stripe_id',
            'stripe_plan' => 'price_test',
            'quantity' => 1,
            'stripe_status' => 'active'
        ]);
    }

    public function testUserWithoutPlanCannotWatchPremiumLesson(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
//        $this->fakeSubscribe($user);
        $this->actingAs($user);
        $lesson = factory(Lesson::class)->create(['premium' => 1]);
        $this->get(route('watch-series.lesson', ['series' => $lesson->series->slug, 'lesson' => $lesson->id]))
            ->assertRedirect('subscribe');

//        dd($user->subscribedToPlan('price_test', 'default'));
    }

    public function testUserWithPlanCanWatchAnyLesson(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->fakeSubscribe($user);
//        $this->fakeSubscribe($user);
        $this->actingAs($user);
        $lesson = factory(Lesson::class)->create(['premium' => 1]);
        $lesson2 = factory(Lesson::class)->create(['premium' => 0]);
        $this->get(route('watch-series.lesson', ['series' => $lesson->series->slug, 'lesson' => $lesson->id]))
            ->assertStatus(200)->assertViewIs('frontend.lesson.show');
        $this->get(route('watch-series.lesson', ['series' => $lesson2->series->slug, 'lesson' => $lesson2->id]))
            ->assertStatus(200)->assertViewIs('frontend.lesson.show');

//        dd($user->subscribedToPlan('price_test', 'default'));
    }


}
