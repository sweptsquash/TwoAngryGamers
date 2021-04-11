<?php

namespace App\Http\Requests;

use App\Models\Editors;
use Illuminate\Foundation\Http\FormRequest;

class CreateEditorRequest extends FormRequest
{
    public function authorize()
    {
        $uuid = $this->input('uuid');

        if (! empty($uuid)) {
            $editor = Editors::where('id', $uuid)->first();

            if (! empty($editor) && $editor->hasPermission('Create Editors')) {
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
            'name'      => ['required', 'string'],
            'role_id'   => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'uuid'      => 'Current Editors UUID is required.',
            'id'        => 'Editors Twitch ID is a required field.',
            'name'      => 'Editors Twitch Name is a required field.',
            'role_id'   => 'Editors Role is a required value.',
        ];
    }
}
