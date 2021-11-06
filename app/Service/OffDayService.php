<?php

namespace App\Service;

use App\Repository\OffDayRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class OffDayService
{
    private $nueipService;
    private $repository;
    private $userRepository;

    public function __construct(NueipService $nueipService, OffDayRepository $repository, UserRepository $userRepository)
    {
        $this->nueipService = $nueipService;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function upgrade()
    {
        $this->userRepository->getAll()->chunk(50)->map(function ($users) {
            foreach ($users as $user) {
                try {
                    if ($res = $this->nueipService->setUser($user)->getOffDay()) {
                        $this->save($user, $res);
                    }
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        });
    }

    public function save($user, $res)
    {
        foreach ($res as $item) {
            $endDate = Carbon::parse($item['end_date']);
            for ($date = Carbon::parse($item['start_date']); $date <= $endDate; $date->addDay()) {
                $params = [
                    'user_id' => $user->id,
                    'date' => $date->toDateString(),
                ];
                $this->repository->save($params);
            }
        }
    }

    public function delete($user, $res)
    {
        $dates = [];
        foreach ($res as $item) {
            $endDate = Carbon::parse($item['end_date']);
            for ($date = Carbon::parse($item['start_date']); $date <= $endDate; $date->addDay()) {
                $dates[] = $date->toDateString();
            }
        }
        $this->repository->deleteDatesForUser($user->id, $dates);
    }
}
