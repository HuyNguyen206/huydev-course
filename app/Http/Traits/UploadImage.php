<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;

trait UploadImage {

    public function uploadImage(){
        $image = $this->file('image');
        $this->fileName = Str::slug($this->title).'.'.$image->getClientOriginalExtension();
        $this->imagePath = $image->storePubliclyAs('series',   $this->fileName);
        return $this;
    }
}
