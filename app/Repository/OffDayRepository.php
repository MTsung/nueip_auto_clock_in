<?php

namespace App\Repository;

use App\Models\OffDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OffDayRepository
{
    public function module(): Model
    {
        return app(OffDay::class);
    }

    public function save($rows)
    {
        $this->module()->upsert($rows, ['user_id', 'date'], ['user_id', 'date']);
    }

    public function findByUser($userId)
    {
        return $this->module()->where('user_id', $userId)->pluck('date');
    }

    public function findByUserAndDate(Carbon $date, $userId)
    {
        return $this->module()
            ->select(['id', 'date', DB::raw('0 as is_work_day'), DB::raw('1 as is_by_user')])
            ->where('user_id', $userId)
            ->where('date', $date)
            ->first();
    }

    public function deleteDatesForUser($userId, $dates)
    {
        return $this->module()
            ->where('user_id', $userId)
            ->whereIn('date', $dates)
            ->delete();
    }
}
