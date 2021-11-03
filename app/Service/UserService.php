<?php

namespace App\Service;

use App\Repository\CalendarDateRepository;
use App\Repository\OffDayRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private $repository;
    private $calendarDateRepository;
    private $offDayRepository;

    public function __construct(UserRepository $repository, CalendarDateRepository $calendarDateRepository, OffDayRepository $offDayRepository)
    {
        $this->repository = $repository;
        $this->calendarDateRepository = $calendarDateRepository;
        $this->offDayRepository = $offDayRepository;
    }

    public function getClockInUserIds($time)
    {
        return $this->repository->getClockInUserIds($time);
    }

    public function getClockOutUserIds($time)
    {
        return $this->repository->getClockOutUserIds($time);
    }

    public function getOffDays()
    {
        return $this->calendarDateRepository->getOffDays()->merge($this->offDayRepository->findByUser(Auth::id()));
    }
}
