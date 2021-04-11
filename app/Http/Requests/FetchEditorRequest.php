<?php

namespace App\Http\Requests;

use App\Models\Editors;
use Illuminate\Foundation\Http\FormRequest;

class FetchEditorRequest extends FormRequest
{
    public function authorize()
    {
        $uuid = $this->input('uuid');

        if (! empty($uuid)) {
            $editor = Editors::where('id', $uuid)->first();

            if (! empty($editor)) {
                return true;
            }
        }

        return false;
    }

    public function rules()
    {
        return [
            'uuid'      => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'uuid'      => 'Current Editors UUID is required.',
        ];
    }
}
