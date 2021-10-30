<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineNotifyCallbackRequest extends FormRequest
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
            'code' => 'required',
        ];
    }

    public function getInput()
    {
        $data = parent::all();
        return [
            'code' => $data['code'],
        ];
    }
}
