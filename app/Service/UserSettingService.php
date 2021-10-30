<?php

namespace App\Service;

use App\Repository\UserSettingRepository;
use Illuminate\Support\Facades\Auth;

class UserSettingService
{
    private $repository;

    public function __construct(UserSettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save($params)
    {
        $this->repository->save(Auth::id(), $params);
    }
}
