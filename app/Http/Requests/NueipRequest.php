<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class NueipRequest extends FormRequest
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
            'company' => 'required',
            'account' => 'required',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'company' => '公司代碼',
            'account' => '員工編號',
            'password' => '密碼',
        ];
    }

    public function getInput()
    {
        // TODO: 打 Nueip 登入 判斷資訊是否正確
        $data = parent::all();
        return [
            'company' => $data['company'],
            'account' => $data['account'],
            'password' => Crypt::encryptString($data['password']),
        ];
    }
}
