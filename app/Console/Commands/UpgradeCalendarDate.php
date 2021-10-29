<?php

namespace App\Console\Commands;

use App\Service\CalendarDateService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpgradeCalendarDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar-date:upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新行事曆';

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
        DB::beginTransaction();
        try {
            app(CalendarDateService::class)->upgrade();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return Command::FAILURE;
        }
        DB::commit();
        return Command::SUCCESS;
    }
}
