<?php

namespace App\Http\Controllers;

use App\Http\Requests\NueipRequest;
use App\Service\NueipService;
use App\Service\NueipUserService;
use Exception;

class NueipController extends Controller
{
    private $service;
    private $nueipService;

    public function __construct(NueipUserService $service, NueipService $nueipService)
    {
        $this->service = $service;
        $this->nueipService = $nueipService;
    }

    public function index()
    {
        $user = $this->service->getUser();
        return view('setting.nueip.index', compact('user'));
    }

    public function save(NueipRequest $request)
    {
        $data = $request->all();
        if (!$this->nueipService->login($data['company'], $data['account'], $data['password'])) {
            return redirect()->back()->with('error', 'NUEiP 資訊錯誤');
        }

        $input = $request->getInput();
        try {
            $this->service->save($input);
        } catch (Exception $e) {
            $this->addErrorLog($e);
            return redirect()->back()->with('error', '寫入失敗');
        }
        return redirect()->back()->with('success', '成功');
    }
}
