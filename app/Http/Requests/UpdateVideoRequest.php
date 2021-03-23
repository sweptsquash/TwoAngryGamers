<?php

namespace App\Http\Requests;

use App\Models\Editors;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVideosRequest extends FormRequest
{
    public function authorize()
    {
        $uuid = $this->input('uuid');

        if (! empty($uuid)) {
            $editor = Editors::where('id', $uuid)->first();

            if (! empty($editor) && $editor->hasPermission('Edit Videos')) {
                return true;
            }
        }

        return false;
    }

    public function rules()
    {
        return [
            'uuid'      => ['required', 'integer'],
            'id'        => ['required', 'integer'],
            'title'     => ['required', 'string'],
            'author'    => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'uuid'      => 'Current Editors UUID is required.',
            'id'        => 'Video ID is required.',
            'title'     => 'Video Title is required.',
            'author'    => 'Video Author is required.',
        ];
    }
}
