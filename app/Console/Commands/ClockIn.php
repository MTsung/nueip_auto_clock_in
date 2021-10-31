<?php

namespace App\Console\Commands;

use App\Jobs\ClockInJob;
use App\Service\CalendarDateService;
use App\Service\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClockIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clock-in';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '打卡';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 工作日判斷
        $calendarDateService = app(CalendarDateService::class);
        $dataStatus = $calendarDateService->getDateStatus(Carbon::today());
        $isWorkDay = $dataStatus->is_work_day ?? 0;
        if (!$isWorkDay) {
            return Command::SUCCESS;
        }

        $now = Carbon::now()->format('H:i:00');
        $userService = app(UserService::class);
        $userService->getClockInUserIds($now)->map(function ($id) {
            dispatch(new ClockInJob($id, 1));
        });
        $userService->getClockOutUserIds($now)->map(function ($id) {
            dispatch(new ClockInJob($id, 2));
        });

        return Command::SUCCESS;
    }
}
