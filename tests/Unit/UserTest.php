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
}
