<?php

namespace App\Repository;

use App\Models\CalendarDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CalendarDateRepository
{
    public function module(): Model
    {
        return app(CalendarDate::class);
    }

    public function save($rows)
    {
        $this->module()->upsert($rows, ['date'], ['is_work_day', 'date']);
    }

    public function findByDate(Carbon $date)
    {
        return $this->module()->where('date', $date)->first();
    }

    public function getOffDays()
    {
        return $this->module()->where('is_work_day', 0)->pluck('date');
    }
}
