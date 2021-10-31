<?php

namespace App\Jobs;

use App\Models\ClockLog;
use App\Models\User;
use App\Service\NueipService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ClockInJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user_id;
    private $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $type)
    {
        Log::info('ClockInJob', [$user_id, $type]);
        $this->user_id = $user_id;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $nueipService = app(NueipService::class);
        $nueipService = $nueipService->setUser(User::find($this->user_id));
        try {
            switch ($this->type) {
                case '1':
                    $nueipService->clockIn();
                    break;
                case '2':
                    $nueipService->clockOut();
                    break;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            ClockLog::query()->create([
                'user_id' => $this->user_id,
                'type' => $this->type,
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
