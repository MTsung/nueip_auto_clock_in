# NUEiP 自動打卡系統

本作品僅為研究及練習使用。

行事曆工作日使用公共 API : [政府行政機關辦公日曆表](https://data.ntpc.gov.tw/datasets/308DCD75-6434-45BC-A95F-584DA4FED251)

## Install

1. run `copy .env.example .env`
2. run `php artisan key:generate`
3. 設定 env，DB 連線資訊、Mailer 設定、LINE Notify 設定 ([參考](https://github.com/MTsung/LINE_Notify_PHP))
4. run `composer install`
5. run `npm install`
6. run `php artisan migrate`
7. run `php artisan calendar-date:upgrade` 初始化行事曆
8. [Running The Scheduler](https://laravel.com/docs/8.x/scheduling#running-the-scheduler)
9. [job 設定](https://laravel.com/docs/8.x/queues#introduction) (非必要)

## 實際畫面
![](https://raw.githubusercontent.com/MTsung/nueip_auto_clock_in/master/public/img/home.png)
![](https://raw.githubusercontent.com/MTsung/nueip_auto_clock_in/master/public/img/line_notify.png)

### License
[MIT license](https://opensource.org/licenses/MIT)
