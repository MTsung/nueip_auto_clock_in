<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSettingRequest extends FormRequest
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
            'auto_clock_in' => 'required|bool',
            'auto_clock_out' => 'required|bool',
            'clock_in_time' => 'nullable|date_format:H:i',
            'clock_out_time' => 'nullable|date_format:H:i',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'auto_clock_in' => '下班自動打卡',
            'auto_clock_out' => '上班自動打卡',
            'clock_in_time' => '下班打卡時間',
            'clock_out_time' => '上班打卡時間',
            'lat' => '緯度',
            'lng' => '經度',
        ];
    }

    public function getInput()
    {
        $data = parent::all();
        return [
            'auto_clock_in' => $data['auto_clock_in'],
            'auto_clock_out' => $data['auto_clock_out'],
            'clock_in_time' => $data['clock_in_time'] ?? null,
            'clock_out_time' => $data['clock_out_time'] ?? null,
            'lat' => $data['lat'] ?? 0,
            'lng' => $data['lng'] ?? 0,
        ];
    }


}
