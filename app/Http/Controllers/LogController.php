<?php

namespace App\Http\Controllers;

use App\Service\ClockLogService;

class LogController extends Controller
{
    private $service;

    public function __construct(ClockLogService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $logs = $this->service->getLogs();
        return view('logs.index', compact('logs'));
    }
}
