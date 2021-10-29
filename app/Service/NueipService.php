<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;

class NueipService
{
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
        return $redirectUrl === $this->loginSuccessUrl;
    }
}
