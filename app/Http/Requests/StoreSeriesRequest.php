<?php

namespace App\Http\Requests;

use App\Model\Series;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Http\Traits\UploadImage;

class StoreSeriesRequest extends FormRequest
{
    use UploadImage;
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image'
        ];
    }


    public function storeSeries(){
       $series = Series::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'image_url' => $this->imagePath
        ]);
        session()->flash('success', 'series was created successful');
        return redirect()->route('series.show', $series->slug);
    }
}
