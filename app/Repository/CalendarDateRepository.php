<?php

namespace App\Repository;

use App\Models\CalendarDate;
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
}
