<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_series()
    {
        $this->withoutExceptionHandling();
        Storage::fake(config('filesystems.default'));
        $response = $this->post('admin/series',
        [
            'title' => 'new vueJS',
            'description' => 'vueJS description',
            'image' => UploadedFile::fake()->image('test-image.png')
        ]);
        $response->assertRedirect();
        Storage::disk(config('filesystems.default'))->assertExists("series/".Str::slug('new vueJS').".png");
        $this->assertDatabaseHas('series',[
            'title' => 'new vueJS',
            'slug' => Str::slug('new vueJS'),
            'description' => 'vueJS description',
            'image_url' => "series/".Str::slug('new vueJS').".png"
        ]);
    }
}
