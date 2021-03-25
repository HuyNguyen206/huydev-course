<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
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
        $this->adminLogin();
        $this->withoutExceptionHandling();
        Storage::fake(config('filesystems.default'));
        $response = $this->post('admin/series',
        [
            'title' => 'new vueJS',
            'description' => 'vueJS description',
            'image' => UploadedFile::fake()->image('test-image.png')
        ]);
        $response->assertRedirect()->assertSessionHas('success', 'series was created successful');
        Storage::disk(config('filesystems.default'))->assertExists("series/".Str::slug('new vueJS').".png");
        $this->assertDatabaseHas('series',[
            'title' => 'new vueJS',
            'slug' => Str::slug('new vueJS'),
            'description' => 'vueJS description',
            'image_url' => "series/".Str::slug('new vueJS').".png"
        ]);
    }

    /**
     * @group test-validation-series
     */
    public function test_series_must_be_create_with_title(){
//        $this->withoutExceptionHandling();
        $this->adminLogin();
        Storage::fake(config('filesystems.default'));
        $response = $this->post('/admin/series',
            [
                'description' => 'vueJS description',
                'image' => UploadedFile::fake()->image('test-image.png')
            ]);
        $response->assertSessionHasErrors('title');
    }


    /**
     * @group test-validation-series
     */
    public function test_series_must_be_create_with_description(){
//        $this->withoutExceptionHandling();
        $this->adminLogin();
        Storage::fake(config('filesystems.default'));
        $response = $this->post('admin/series',
            [
                'title' => 'new vueJS',
//                'description' => 'vueJS description',
                'image' => UploadedFile::fake()->image('test-image.png')
            ]);
        $response->assertSessionHasErrors('description');
    }
//
//
    /**
     * @group test-validation-series
     */
    public function test_series_must_be_create_with_image(){
//        $this->withoutExceptionHandling();
        $this->adminLogin();
        Storage::fake(config('filesystems.default'));
        $response = $this->post('admin/series',
            [
                'title' => 'new vueJS',
                'description' => 'vueJS description',
//                'image' => UploadedFile::fake()->image('test-image.png')
            ]);
        $response->assertSessionHasErrors('image');
    }
    /**
     * @group test-validation-series
     */
    public function test_series_must_be_create_with_image_which_actually_image(){
//        $this->withoutExceptionHandling();
        $this->adminLogin();
        Storage::fake(config('filesystems.default'));
        $response = $this->post('admin/series',
            [
                'title' => 'new vueJS',
                'description' => 'vueJS description',
                'image' => 'invalid-image'
            ]);
        $response->assertSessionHasErrors('image');
    }

    public function test_only_admin_can_create_series(){
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->get('admin/series/create')
            ->assertRedirect('/')
            ->assertSessionHas('error', "You aren't authorize to access this page");

//        $admin = User::create([
//            'name' => 'huy',
//            'username' => 'huy',
//            'email' => 'huy@gmail.com',
//            'password' => bcrypt('password')
//        ]);
//        $this->actingAs($admin);
//        $this->get('admin/series/create')
//            ->assertStatus(200)
//            ->assertSessionHas('success', "You are authorize to access this page");


    }
}
