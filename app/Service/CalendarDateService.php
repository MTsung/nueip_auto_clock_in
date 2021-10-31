<?php

namespace App\Service;

use App\Repository\CalendarDateRepository;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CalendarDateService
{
    private $repository;
    private $url;

    public function __construct(CalendarDateRepository $repository)
    {
        $this->repository = $repository;
        $this->url = 'https://data.ntpc.gov.tw/api/datasets/308DCD75-6434-45BC-A95F-584DA4FED251/json?size=100&page=';
    }

    public function upgrade()
    {
        $resDate = [];
        $page = 0;
        $dates = $this->getCalendar($page);
        while ($dates = $this->getCalendar($page)) {
            $resDate = array_merge($resDate, $dates);
            $page++;
        }
        $resDate = collect($resDate);

        $allDate = [];
        $endDate = Carbon::today()->addYear()->lastOfYear();
        for ($date = Carbon::today(); $date <= $endDate; $date->addDay()) {
            $allDate[] = [
                'date' => $date->toDateString(),
                'is_work_day' => $resDate->where('date', $date->toDateString())->first()['is_work_day'] ?? 1,
            ];
        }
        collect($allDate)->sortBy('date')->chunk(1000)->map(function ($v) {
            $this->repository->save($v->toArray());
        });
    }

    private function getCalendar($page)
    {
        try {
            $client = new Client(['verify' => false]);
            $res = $client->get($this->url . $page)->getBody();
            $res = json_decode($res, true);
            foreach ($res as $k => $v) {
                $res[$k] = [
                    'date' => Carbon::parse($v['date'])->toDateString(),
                    'is_work_day' => $v['isHoliday'] == '是' ? 0 : 1,
                ];
            }
            return $res;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
    }

    public function getDateStatus(Carbon $date)
    {
        return $this->repository->findByDate($date);
    }
}
