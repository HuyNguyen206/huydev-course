<?php

namespace Tests\Unit;

use App\Model\Lesson;
use App\Model\Series;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserCanCompleteLesson()
    {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $this->assertEquals(Redis::smembers("user:$user->id:series:$lesson->series_id"), [$lesson->id, $lesson2->id]);
        $this->assertEquals($user->getNumberCompletedLessonBySeries($lesson->series_id), 2);
    }

    public function testUserHasPercentageSeriesComplete()
    {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        factory(Lesson::class, 2)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $this->assertEquals($user->percentageCompleteForSeries(1), 50);
    }

    public function testUserStartSeries()
    {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3= factory(Lesson::class)->create();
        $user->completeLesson($lesson2);
        $this->assertTrue($user->hasStartSeries($lesson2->series_id));
        $this->assertFalse($user->hasStartSeries($lesson3->series_id));
    }

    public function testUserCanGetCompleteLessonForSeries()
    {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        factory(Lesson::class, 2)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $completedLessons = $user->getCompletedLessonBySeries($lesson2->series_id);
        $this->assertInstanceOf(Collection::class,$completedLessons );
        $this->assertInstanceOf(Lesson::class, $completedLessons->random());
        $this->assertTrue($completedLessons->contains($lesson));
        $this->assertTrue($completedLessons->contains($lesson2));
        $this->assertFalse($completedLessons->contains($lesson3));
//        $this->assertEquals($user->getCompletedLessonBySeries($lesson2->series_id), 2);
//        $this->assertFalse($user->hasStartSeries($lesson3->series_id));
    }

    public function testCanCheckIfUserHasCompleteLesson(){
        $this->flushRedis();
        $this->withoutExceptionHandling();
        $user = $this->adminLogin();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);

        $user->completeLesson($lesson);
        $this->assertTrue($user->hasCompleteLesson($lesson));
        $this->assertFalse($user->hasCompleteLesson($lesson2));
    }

    public function testCanGetAllSeriesBeingWatchByUser(){
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create([
            'series_id' => 2
        ]);
        $lesson5 = factory(Lesson::class)->create();
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);
        $seriesBeingWatch =  $user->getSeriesBeingWatch();
        $this->assertInstanceOf(Collection::class,$seriesBeingWatch);
        $this->assertInstanceOf(Series::class, $seriesBeingWatch->random());
        $this->assertTrue(in_array($lesson->series_id, $seriesBeingWatch->pluck('id')->all()));
//        dd($lesson3->series);
        $this->assertTrue(in_array($lesson3->series_id, $seriesBeingWatch->pluck('id')->all()));

        $this->assertFalse(in_array($lesson5->series_id, $seriesBeingWatch->pluck('id')->all()));
    }

    public function testCanGetAllLessonCompletedByUser(){
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create([
            'series_id' => 2
        ]);
        $lesson5 = factory(Lesson::class)->create();
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);
        $user->completeLesson($lesson5);

        $totalCompletedLesson =  $user->getTotalNumberOfCompletedLesson();
        $this->assertEquals(3,$totalCompletedLesson);

    }


    public function testCanGetNextLessonToWatchForSeries(){
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create(['episode_number' => 1]);
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
            'episode_number' => 2
        ]);
        $lesson3 = factory(Lesson::class)->create([
            'series_id' => 1,
            'episode_number' => 3
        ]);
//        $lesson5 = factory(Lesson::class)->create();
        $user->completeLesson($lesson);
        $nextLesson = $user->getNextLessonToWatch($lesson->series_id);
//        $user->completeLesson($lesson3);
//        $user->completeLesson($lesson5);

        $this->assertEquals($lesson2->id,$nextLesson->id);
        $user->completeLesson($lesson2);
        $this->assertEquals($lesson3->id,$user->getNextLessonToWatch($lesson->series_id)->id);
        $user->completeLesson($lesson3);
        $this->assertEquals(null,$user->getNextLessonToWatch($lesson->series_id));
    }
}
