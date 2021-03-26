<?php

namespace Tests\Feature;

use App\Model\Series;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanCreateLesson()
    {
        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $this->adminLogin();
        $response = $this->postJson("admin/$series->id/lessons", [
            'title' => 'This is feature test',
            'video_id' => '421322',
            'description' => 'this is test',
            'episode_number' => 'number 9'
        ])->assertStatus(200);
        $this->assertDatabaseHas('lessons', [
            'title' => 'This is feature test',
            'video_id' => '421322',
            'series_id' => $series->id
        ]);
    }

    public function testTitleIsRequiredToCreateLesson(){
        $series = factory(Series::class)->create();
        $this->adminLogin();
        $response = $this->postJson("admin/$series->id/lessons", [
//            'title' => 'This is feature test',
            'video_id' => '421322',
            'description' => 'this is test',
            'episode_number' => 'number 9'
        ])->assertStatus(422)->assertSessionHasErrors('title');

    }
}
