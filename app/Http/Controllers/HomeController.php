<?php

namespace App\Http\Controllers;

use App\Service\ClockLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $clockLogService;

    public function __construct(ClockLogService $clockLogService)
    {
        $this->clockLogService = $clockLogService;
    }

    public function index(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? '')->startOfDay();
        $logs = $this->clockLogService->getLogs(0, $date);
        return view('home', compact('logs'));
    }
}
