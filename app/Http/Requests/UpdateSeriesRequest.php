<?php

namespace App\Http\Requests;

use App\Http\Traits\UploadImage;
use Illuminate\Foundation\Http\FormRequest;
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


}
