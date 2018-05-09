<?php

namespace Cht\Listeners;

use Carbon\Carbon;
use Cht\Events\SchedulingEvent;
use Cht\Models\Cron;
use Cht\Services\CronService;

class SchedulingListener
{
    /**
     * @var CronService
     */
    private $cronService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CronService $cronService)
    {
        //
        $this->cronService = $cronService;
    }

    /**
     * Handle the event.
     *
     * @param  SchedulingEvent $event
     * @return void
     */
    public function handle(SchedulingEvent $event)
    {
        $now = Carbon::now();
        $now->setTime($now->hour, $now->minute, 0);

        $start = "{$now->format('Y-m-d H:i')}:00";
        $end = "{$now->format('Y-m-d H:i')}:59";

        $crons = Cron::whereBetween('next_execution', [$start, $end])->get();

        foreach ($crons as $cron) {
            $cron->next_execution = $this->cronService->parseExpressionToNextDate($cron->expression, true);
            $cron->save();
        }
    }
}
