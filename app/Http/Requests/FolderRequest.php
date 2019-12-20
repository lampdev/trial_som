<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueFolder;
use Illuminate\Support\Facades\App;

class FolderRequest extends FormRequest
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
            'title' => ['required','string','max:255', App::make(UniqueFolder::class)],
            'parent_id' => 'required|integer',
            'id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Please provide a folder name'
        ];
    }
}
