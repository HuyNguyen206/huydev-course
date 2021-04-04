<?php

namespace Tests\Feature;

use App\Model\Lesson;
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
//        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $this->adminLogin();
        $response = $this->post("admin/$series->id/lessons", [
//            'title' => 'This is feature test',
            'video_id' => '421322',
            'description' => 'this is test',
            'episode_number' => 'number 9'
        ])->assertStatus(302)->assertSessionHasErrors('title');

    }

    public function testDescriptionIsRequiredToCreateLesson(){
//        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $this->adminLogin();
        $response = $this->post("admin/$series->id/lessons", [
            'title' => 'This is feature test',
            'video_id' => '421322',
//            'description' => 'this is test',
            'episode_number' => 'number 9'
        ])->assertStatus(302)->assertSessionHasErrors('description');

    }

    public function testCanGetNextAndPreviousLesson(){
        $lesson = factory(Lesson::class)->create(['episode_number' => 200]);
        $lesson2 = factory(Lesson::class)->create(['episode_number' => 100, 'series_id' => 1]);
        $lesson3 = factory(Lesson::class)->create(['episode_number' => 400, 'series_id' => 1]);

        $this->assertEquals($lesson2->getNextLesson()->id, $lesson->id);
        $this->assertEquals($lesson2->id,$lesson2->getPreviousLesson()->id);
        $this->assertEquals($lesson3->id,$lesson->getNextLesson()->id);
        $this->assertEquals($lesson2->id,$lesson->getPreviousLesson()->id);
        $this->assertEquals($lesson3->id, $lesson3->getNextLesson()->id);
    }

}
