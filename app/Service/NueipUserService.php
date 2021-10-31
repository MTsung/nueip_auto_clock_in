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

    public function userExist($id = 0)
    {
        $user = $this->getUser($id);
        $check = strlen($user->company) * strlen($user->account) * strlen($user->password);
        return (bool) $check;
    }

    public function getUser($id = 0)
    {
        return $this->repository->find($id ?: Auth::id());
    }

    public function save($params)
    {
        $this->repository->save(Auth::id(), $params);
    }
}
