<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingRequest;
use App\Service\CalendarDateService;
use App\Service\ClockLogService;
use App\Service\NueipUserService;
use App\Service\UserSettingService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $clockLogService;
    private $calendarDateService;
    private $userSettingService;
    private $nueipUserService;

    public function __construct(ClockLogService $clockLogService, CalendarDateService $calendarDateService, UserSettingService $userSettingService, NueipUserService $nueipUserService)
    {
        $this->clockLogService = $clockLogService;
        $this->calendarDateService = $calendarDateService;
        $this->userSettingService = $userSettingService;
        $this->nueipUserService = $nueipUserService;
    }

    public function index(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? '')->startOfDay();
        $logs = $this->clockLogService->getLogs(0, $date);
        if (!$setting = Auth::user()->setting) {
            $this->userSettingService->save([]);
            $setting = Auth::user()->setting()->first();
        }
        $dateStatus = $this->calendarDateService->getDateStatus($date);
        return view('home', compact('logs', 'setting', 'dateStatus'));
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
