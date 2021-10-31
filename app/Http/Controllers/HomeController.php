<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingRequest;
use App\Service\CalendarDateService;
use App\Service\ClockLogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $clockLogService;
    private $calendarDateService;

    public function __construct(ClockLogService $clockLogService, CalendarDateService $calendarDateService)
    {
        $this->clockLogService = $clockLogService;
        $this->calendarDateService = $calendarDateService;
    }

    public function index(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? '')->startOfDay();
        $logs = $this->clockLogService->getLogs(0, $date);
        $setting = Auth::user()->setting;
        $dateStatus = $this->calendarDateService->getDateStatus($date);
        return view('home', compact('logs', 'setting', 'dateStatus'));
    }

    public function saveSetting(SaveSettingRequest $request)
    {
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
