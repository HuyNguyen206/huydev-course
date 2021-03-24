<?php

namespace App\Http\Requests;

use App\Model\Series;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreSeriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function uploadImage(){
        $image = $this->file('image');
        $this->fileName = Str::slug($this->title).'.'.$image->getClientOriginalExtension();
        $this->imagePath = $image->storePubliclyAs('series',   $this->fileName);
        return $this;
    }

    public function storeSeries(){
        Series::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'image_url' => $this->imagePath
        ]);
    }
}
