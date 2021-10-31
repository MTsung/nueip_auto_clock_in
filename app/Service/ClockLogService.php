<?php

namespace App\Service;

use App\Repository\ClockLogRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClockLogService
{
    private $repository;

    public function __construct(ClockLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getLogs($id = 0, Carbon $date = null)
    {
        return $this->repository->getLogs($id ?: Auth::id(), $date);
    }
}
