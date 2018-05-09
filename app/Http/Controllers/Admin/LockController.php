<?php

namespace Cht\Http\Controllers\Admin;

use Cht\Http\Controllers\Controller;

class LockController extends Controller
{
    public function index()
    {
        return view('admin.lock.index');
    }

    public function lock()
    {
        session()->put('lockScreen', 1);

        return response()
            ->redirectToRoute('lock.index');
    }
}
