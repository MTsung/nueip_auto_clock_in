<?php

namespace App\Http\Controllers;

use App\Http\Requests\LineNotifyCallbackRequest;
use App\Service\LineNotifyService;
use App\Service\UserSettingService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LineNotifyController extends Controller
{
    private $service;
    private $userSettingService;

    public function __construct(LineNotifyService $service, UserSettingService $userSettingService)
    {
        $this->service = $service;
        $this->userSettingService = $userSettingService;
    }

    public function index()
    {
        return view('line-notify.index');
    }

    public function bind()
    {
        return $this->service->authorization();
    }

    public function del()
    {
        DB::beginTransaction();
        try {
            $token = Auth::user()->setting->line_notify_token;
            Auth::user()->setting()->update(['line_notify_token' => null]);
            $this->service->rmToken($token);
            DB::commit();
            return redirect(route('setting.line-notify.index'))->with('success', '解除綁定成功');
        } catch (Exception $e) {
            DB::rollBack();
            $this->addErrorLog($e);
            return redirect(route('setting.line-notify.index'))->with('error', '解除綁定失敗');
        }
    }

    public function callback(LineNotifyCallbackRequest $request)
    {
        $input = $request->getInput();
        try {
            $params = [
                'line_notify_token' => $this->service->getToken($input['code']),
            ];
            $this->userSettingService->save($params);
            return redirect(route('setting.line-notify.index'))->with('success', '綁定成功');
        } catch (Exception $e) {
            $this->addErrorLog($e);
            return redirect(route('setting.line-notify.index'))->with('error', '未知錯誤');
        }
    }
}
