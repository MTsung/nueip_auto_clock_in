<?php

namespace App\Http\Controllers;

use App\Service\CalendarDateService;
use App\Service\ClockLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $dateStatus = $this->calendarDateService->getDateStatus($date);
        return view('home', compact('logs', 'dateStatus'));
    }
}
