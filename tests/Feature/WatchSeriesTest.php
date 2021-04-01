<?php

namespace Tests\Feature;

use App\Model\Lesson;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WatchSeriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanCompleteSeries()
    {
        $this->flushRedis();
        $this->withoutExceptionHandling();
        $user = $this->adminLogin();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);

        $this->post('/series/complete-lesson/'.$lesson->id)
            ->assertStatus(200);
        $this->assertTrue($user->hasCompleteLesson($lesson));
        $this->assertFalse($user->hasCompleteLesson($lesson2));
    }


}
