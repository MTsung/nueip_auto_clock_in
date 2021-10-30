<?php

namespace App\Service;

use App\Repository\ClockLogRepository;
use Illuminate\Support\Facades\Auth;

class ClockLogService
{
    private $repository;

    public function __construct(ClockLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getLogs($id = 0)
    {
        return $this->repository->getLogs($id ?: Auth::id());
    }
}
