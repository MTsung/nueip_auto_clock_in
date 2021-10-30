<?php

namespace App\Repository;

use App\Models\ClockLog;
use Illuminate\Database\Eloquent\Model;

class ClockLogRepository
{
    public function module(): Model
    {
        return app(ClockLog::class);
    }

    public function addLog($user_id, $res, $fromData)
    {
        $params = [
            'user_id' => $user_id,
            'type' => $fromData['id'],
            'status' => $res['status'],
            'message' => $res['message'],
        ];
        $this->module()->query()->create($params);
    }
}
