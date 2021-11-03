<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    public function module(): Model
    {
        return app(User::class);
    }

    public function getClockInUserIds($time)
    {
        return $this->module()
            ->query()
            ->select('users.id')
            ->join('user_setting', 'users.id', 'user_setting.user_id')
            ->where('auto_clock_in', 1)
            ->where('clock_in_time', $time)
            ->pluck('id');
    }

    public function getClockOutUserIds($time)
    {
        return $this->module()
            ->query()
            ->select('users.id')
            ->join('user_setting', 'users.id', 'user_setting.user_id')
            ->where('auto_clock_out', 1)
            ->where('clock_out_time', $time)
            ->pluck('id');
    }

    public function getAll()
    {
        return $this->module()->all();
    }
}
