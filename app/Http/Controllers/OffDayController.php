<?php

namespace App\Http\Controllers;

use App\Http\Requests\OffDayRequest;
use App\Service\OffDayService;
use Auth;
use Exception;

class OffDayController extends Controller
{
    private $service;

    public function __construct(OffDayService $service)
    {
        $this->service = $service;
    }

    public function save(OffDayRequest $request)
    {
        $input = $request->getInput();
        try {
            $this->service->save(Auth::user(), $input);
        } catch (Exception $e) {
            $this->addErrorLog($e);
            return redirect()->back()->with('error', '寫入失敗');
        }
        return redirect()->back();
    }

    public function delete(OffDayRequest $request)
    {
        $input = $request->getInput();
        try {
            $this->service->delete(Auth::user(), $input);
        } catch (Exception $e) {
            $this->addErrorLog($e);
            return redirect()->back()->with('error', '寫入失敗');
        }
        return redirect()->back();
    }
}
