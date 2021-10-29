<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class CreatePostRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048'
        ];

    }
}


?>
