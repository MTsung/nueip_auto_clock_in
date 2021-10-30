<?php

namespace App\Repository;

use App\Models\ClockLog;
use Carbon\Carbon;
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

    public function getLogs($user_id, Carbon $date = null)
    {
        return $this->module()
            ->query()
            ->where('user_id', $user_id)
            ->when(isset($date), function ($query) use ($date) {
                $query->where('created_at', '>=', $date);
                $query->where('created_at', '<', $date->clone()->addDay());
            })
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();
    }
}
