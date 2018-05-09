<?php

namespace Cht\Http\Controllers\Admin;

use Cht\Http\Controllers\Controller;
use Cht\Models\Cron;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $totalCron = Cron::all()->count();
        return view('admin.dashboard.index', compact('totalCron'));
    }
}
