<?php

namespace App\Service;

use App\Models\User;
use App\Repository\ClockLogRepository;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class NueipService
{
    private $isLogin;
    private $cookie;
    private $loginUrl;
    private $loginSuccessUrl;
    private $clockUrl;
    private $nueipUserService;
    private $lineNotifyService;
    private $clockLogRepository;
    private $user;

    public function __construct(NueipUserService $nueipUserService, LineNotifyService $lineNotifyService, ClockLogRepository $clockLogRepository)
    {
        $this->nueipUserService = $nueipUserService;
        $this->lineNotifyService = $lineNotifyService;
        $this->clockLogRepository = $clockLogRepository;
        $this->loginUrl = 'https://cloud.nueip.com/login/index/param';
        $this->loginSuccessUrl = 'https://cloud.nueip.com/home';
        $this->clockUrl = 'https://cloud.nueip.com/time_clocks/ajax';
        $this->cookie = new CookieJar();
        $this->isLogin = false;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function login($company, $account, $password)
    {
        $redirectUrl = '';
        $client = new Client(['timeout' => 5, 'verify' => false]);
        $client->post($this->loginUrl, [
            'form_params' => [
                'inputCompany' => $company,
                'inputID' => $account,
                'inputPassword' => $password,
            ],
            'on_stats' => function (TransferStats $stats) use (&$redirectUrl) {
                $redirectUrl = $stats->getHandlerStats()['redirect_url'];
            },
            'allow_redirects' => false,
            'cookies' => $this->cookie,
        ]);
        $this->isLogin = $redirectUrl === $this->loginSuccessUrl;
        return $this->isLogin;
    }

    public function clockIn()
    {
        if (!$token = $this->getToken()) {
            throw new Exception('token is null');
        }
        $fromData = [
            'action' => 'add',
            'id' => 1,
            'attendance_time' => Carbon::now()->toDateTimeString(),
            'token' => $token,
            'lat' => $this->user->setting->lat,
            'lng' => $this->user->setting->lng,
        ];
        $this->callApi($fromData);
    }

    public function clockOut()
    {
        if (!$token = $this->getToken()) {
            throw new Exception('token is null');
        }
        $fromData = [
            'action' => 'add',
            'id' => 2,
            'attendance_time' => Carbon::now()->toDateTimeString(),
            'token' => $token,
            'lat' => $this->user->setting->lat,
            'lng' => $this->user->setting->lng,
        ];
        $this->callApi($fromData);
    }

    public function callApi($fromData)
    {
        try {
            $client = new Client(['timeout' => 5, 'verify' => false]);
            $res = $client->post($this->clockUrl, [
                'form_params' => $fromData,
                'cookies' => $this->cookie,
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            Log::info($this->clockUrl . ' res: ', [$res]);
            $this->sendLineNotify($res);
            $this->clockLogRepository->addLog($this->user->id, $res, $fromData);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

    private function sendLineNotify($res)
    {
        try {
            $params = [
                "message" => "\n" . $res['message'] . "\n" . $res['datetime'],
            ];
            if ($this->user->setting->notify_token) {
                $this->lineNotifyService->snedNotify($this->user->setting->notify_token, $params);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($this->user->setting->notify_token) {
                $this->lineNotifyService->snedNotify($this->user->setting->notify_token, [
                    "message" => "\n不明原因失敗",
                ]);
            }
        }
    }

    private function clockLogin()
    {
        $id = $this->user->id ?? Auth::id();
        if (!$user = $this->nueipUserService->getUser($id)) {
            throw new Exception('user_id:' . $id . '. nueip info is null');
        }
        $company = $user['company'];
        $account = $user['account'];
        $password = Crypt::decryptString($user['password']);
        return $this->login($company, $account, $password);
    }

    private function getToken()
    {
        if (!$this->clockLogin()) {
            throw new Exception('登入失敗');
        }
        $token = '';
        $client = new Client(['timeout' => 5, 'verify' => false]);
        $res = $client->get($this->loginSuccessUrl, [
            'cookies' => $this->cookie,
        ]);
        if ($res->getStatusCode() == 200) {
            $html = $res->getBody()->getContents();
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $xp = new DOMXPath($dom);
            $token = $xp->query('//input[@name="token"]')->item(0)->getAttribute('value');
        }
        return $token;
    }
}
