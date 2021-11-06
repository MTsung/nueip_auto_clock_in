<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffDayRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
        ];
    }

    public function attributes()
    {
        return [
            'date' => '日期',
        ];
    }

    public function getInput()
    {
        $data = parent::all();
        return [
            [
                'start_date' => $data['date'],
                'end_date' => $data['date'],
            ],
        ];
    }
}
