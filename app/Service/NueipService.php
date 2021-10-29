<?php

namespace App\Service;

use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Crypt;

class NueipService
{
    private $isLogin;
    private $cookie;
    private $loginUrl;
    private $loginSuccessUrl;
    private $nueipUserService;

    public function __construct(NueipUserService $nueipUserService)
    {
        $this->nueipUserService = $nueipUserService;
        $this->loginUrl = 'https://cloud.nueip.com/login/index/param';
        $this->loginSuccessUrl = 'https://cloud.nueip.com/home';
        $this->cookie = new CookieJar();
        $this->isLogin = false;
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

    // TODO
    public function clockIn()
    {
        if (!$this->clockLogin()) {
            throw new Exception('登入失敗');
        }
        if (!$token = $this->getToken()) {
            throw new Exception('token is null');
        }
    }

    public function clockOut()
    {

    }

    private function clockLogin()
    {
        $user = $this->nueipUserService->getUser();
        $company = $user['company'];
        $account = $user['account'];
        $password = Crypt::decryptString($user['password']);
        return $this->login($company, $account, $password);
    }

    private function getToken()
    {
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
