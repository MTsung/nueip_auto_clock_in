<?php

namespace App\Http\Controllers;

use App\Http\Requests\NueipRequest;
use App\Service\NueipUserService;
use Exception;

class NueipController extends Controller
{
    private $service;

    public function __construct(NueipUserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = $this->service->getUser();
        return view('setting.nueip.index', compact('user'));
    }

    public function save(NueipRequest $request)
    {
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
