<?php

namespace App\Service;

use App\Repository\NueipUserRepository;
use Illuminate\Support\Facades\Auth;

class NueipUserService
{
    private $repository;

    public function __construct(NueipUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function userExist()
    {
        $user = $this->getUser();
        $check = strlen($user->company) * strlen($user->account) * strlen($user->password);
        return (bool) $check;
    }

    public function getUser()
    {
        return $this->repository->find(Auth::id());
    }

    public function save($params)
    {
        $this->repository->save(Auth::id(), $params);
    }
}
