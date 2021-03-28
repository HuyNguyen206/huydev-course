<?php

namespace App\Http\Requests;

use App\Http\Traits\UploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UpdateSeriesRequest extends FormRequest
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
        ];
    }

    public function updateSeries($series){
        $data = $this->all();
        if($this->has('image')){
            $imagePath = $this->uploadImage()->imagePath;
            if(Storage::exists($series->image_url)){
                Storage::delete($series->image_url);
            }
            $data['image_url'] = $imagePath;
        }
        unset($data['image']);
        $data['slug'] = Str::slug($this->title);
        $series->update($data);
    }


}
