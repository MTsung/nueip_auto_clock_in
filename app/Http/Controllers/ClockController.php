<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingRequest;
use App\Service\NueipUserService;
use App\Service\UserSettingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClockController extends Controller
{
    private $userSettingService;
    private $nueipUserService;

    public function __construct(UserSettingService $userSettingService, NueipUserService $nueipUserService)
    {
        $this->userSettingService = $userSettingService;
        $this->nueipUserService = $nueipUserService;
    }

    public function index(Request $request)
    {
        if (!$setting = Auth::user()->setting) {
            $this->userSettingService->save([]);
            $setting = Auth::user()->setting()->first();
        }
        return view('setting.clock.index', compact('setting'));
    }

    public function saveSetting(SaveSettingRequest $request)
    {
        if (!$this->nueipUserService->userExist()) {
            return redirect(route('setting.nueip'))->with('error', '請先設定 NUEiP 帳號');
        }

        $input = $request->getInput();
        try {
            Auth::user()->setting()->update($input);
        } catch (Exception $e) {
            $this->addErrorLog($e);
            return redirect()->back()->with('error', '寫入失敗');
        }
        return redirect()->back()->with('success', '成功');
    }
}
