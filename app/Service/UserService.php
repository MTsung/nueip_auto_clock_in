<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getClockInUserIds($time)
    {
        return $this->repository->getClockInUserIds($time);
    }

    public function getClockOutUserIds($time)
    {
        return $this->repository->getClockOutUserIds($time);
    }
}
