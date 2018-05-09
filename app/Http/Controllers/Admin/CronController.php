<?php

namespace Cht\Http\Controllers\Admin;

use Cht\Http\Controllers\Controller;
use Cht\Models\Cron;
use Cht\Services\CronService;
use Illuminate\Http\Request;

class CronController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cron = Cron::paginate(15);
        return view('admin.cron.index', compact('cron'));
    }

    /**
     * @param CronService $cronService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CronService $cronService)
    {
        $minutes = $cronService->getMinutesOptions();
        $humanizedMinutes = $cronService->getHumanizedMinutesOptions();

        $hours = $cronService->getHoursOptions();
        $humanizedHours = $cronService->getHumanizedHoursOptions();

        $days = $cronService->getDaysOptions();
        $humanizedDays = $cronService->getHumanizedDaysOptions();

        $months = $cronService->getMonthsOptions();
        $humanizedMonths = $cronService->getHumanizedMonthsOptions();

        $weekdays = $cronService->getWeekdaysOptions();
        $humanizedWeekdays = $cronService->getHumanizedWeekdaysOptions();

        return view(
            'admin.cron.create',
            compact(
                'minutes',
                'humanizedMinutes',
                'hours',
                'humanizedHours',
                'days',
                'humanizedDays',
                'months',
                'humanizedMonths',
                'weekdays',
                'humanizedWeekdays'
            )
        );
    }

    /**
     * @param Request $request
     * @param CronService $cronService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, CronService $cronService)
    {
        $cronService->saveCron($request->all());

        return response()
            ->redirectToRoute('admin.cron.index')
            ->with(['success' => true]);
    }

    /**
     * @param Request $request
     * @param Cron $cron
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Cron $cron)
    {
        $cron->delete();

        $request->session()
            ->flash('success', true);

        return response()
            ->json(['success' => true]);
    }
}
