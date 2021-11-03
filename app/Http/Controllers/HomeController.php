<?php

namespace App\Http\Controllers;

use App\Service\CalendarDateService;
use App\Service\ClockLogService;
use App\Service\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $clockLogService;
    private $calendarDateService;
    private $userService;

    public function __construct(ClockLogService $clockLogService, CalendarDateService $calendarDateService, UserService $userService)
    {
        $this->clockLogService = $clockLogService;
        $this->calendarDateService = $calendarDateService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? '')->startOfDay();
        $logs = $this->clockLogService->getLogs(0, $date);
        $dateStatus = $this->calendarDateService->getDateStatus($date);
        $offDays = $this->userService->getOffDays();
        return view('home', compact('logs', 'dateStatus', 'offDays'));
    }
}
