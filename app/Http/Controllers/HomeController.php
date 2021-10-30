<?php

namespace App\Http\Controllers;

use App\Service\ClockLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $setting = Auth::user()->setting;
        return view('home', compact('logs', 'setting'));
    }
}
