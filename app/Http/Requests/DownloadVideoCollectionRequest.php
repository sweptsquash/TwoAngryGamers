<?php

namespace App\Http\Requests;

use App\Models\Editors;
use Illuminate\Foundation\Http\FormRequest;

class DownloadVideoCollectionRequest extends FormRequest
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
            'ids'       => ['required', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'uuid'      => 'Current Editors UUID is required.',
            'ids'       => 'A collection of IDs is required.',
        ];
    }
}
