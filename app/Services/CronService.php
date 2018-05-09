<?php

namespace Cht\Services;

use Carbon\Carbon;
use Cht\Models\Cron;
use Illuminate\Support\Facades\Log;


/**
 * Class CronService
 * @package Cht\Services
 */
class CronService
{
    const CRON_EXPRESSION_ORDER = [
        'minutes'  => 0,
        'hours'    => 1,
        'days'     => 2,
        'months'   => 3,
        'weekdays' => 4,
    ];

    /**
     * @param array $data
     * @return array|mixed|string
     */
    private function parseMultipleSelect(array $data)
    {
        if (count($data) === 1) {
            return $data[0];
        }

        if (count($data) === 2) {
            return implode(",", $data);
        }

        array_walk($data, function (&$element) {
            $element = (int)$element;
        });

        return $this->parseRanges($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function parseRanges(array $data)
    {
        $data = [
            0
        ];

        $dataCount = count($data);
        $currentIndex = 0;

        if ($dataCount < 2) {
            return $data;
        }

        $parsed = [[$data[0], $data[1]]];

        for ($i = 2; $i < $dataCount; $i++) {
            $total = count($parsed[$currentIndex]);
            $verifyIndex = $total === 1 ? 0 : ($total - 1);
            var_dump($currentIndex, $total, $verifyIndex, $data[$i]);

            if (($parsed[$currentIndex][$verifyIndex] + 1) === $data[$i]) {
                $parsed[$currentIndex][] = $data[$i];
            } else {
                ++$currentIndex;
                $parsed[$currentIndex][0] = $data[$i];
            }
        }

        dd($parsed);
        $parsed2 = [];

        foreach ($parsed as $item) {
            $parsed2[] = $this->parseRangeExpression($item);
        }

        return implode(",", $parsed2);
    }

    /**
     * @param $item
     * @return string
     */
    private function parseRangeExpression($item)
    {
        if (count($item) > 2) {
            return "{$item[0]}-{$item[count($item) - 1]}";
        }
        return implode(",", $item);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function saveCron(array $data)
    {
        $cron = new Cron();
        $cron->expression = implode(" ", $this->getParsedExpression($data));
        $cron->shell_command = $data['command'];
        $cron->description = $data['description'];
        $cron->user_id = auth()->user()->id;

        $cron->next_execution = $this->parseExpressionToNextDate($cron->expression);
        $cron->save();

        return true;
    }

    /**
     * @param $type
     * @return int
     */
    private function getOrderedIndexByType($type)
    {
        $type = str_replace("-select", "", $type);

        if (!isset(self::CRON_EXPRESSION_ORDER[$type])) {
            Log::error("Type {$type} does not exists.");
            abort(500, "Type {$type} does not exists.");
        }

        return self::CRON_EXPRESSION_ORDER[$type];
    }

    /**
     * @return array
     */
    public function getMinutesOptions()
    {
        $minutes = [];

        for ($i = 0; $i <= 59; $i++) {
            $minutes[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        return $minutes;
    }

    /**
     * @return array
     */
    public function getHumanizedMinutesOptions()
    {
        return [
            '*'      => 'Every minute',
            '*/2'    => 'Every even minute',
            '1-59/2' => 'Every odd minute',
            '*/5'    => 'Every 5 minutes',
            '*/15'   => 'Every 15 minutes',
            '*/30'   => 'Every 30 minutes'
        ];
    }

    /**
     * @return array
     */
    public function getHoursOptions()
    {
        $hours = [];

        for ($i = 0; $i < 24; $i++) {
            $hours[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        return $hours;
    }

    /**
     * @return array
     */
    public function getHumanizedHoursOptions()
    {
        return [
            '*'      => 'Every hour',
            '*/2'    => 'Even hours',
            '1-23/2' => 'Odd hours',
            '*/6'    => 'Every 6 hours',
            '*/12'   => 'Every 12 hours',
        ];
    }

    /**
     * @return array
     */
    public function getDaysOptions()
    {
        $days = [];

        for ($i = 0; $i <= 31; $i++) {
            $days[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        return $days;
    }

    /**
     * @return array
     */
    public function getHumanizedDaysOptions()
    {
        return [
            '*'      => 'Every day',
            '*/2'    => 'Even days',
            '1-31/2' => 'Odd days',
            '*/5'    => 'Every 5 days',
            '*/10'   => 'Every 10 days',
            '*/15'   => 'Every half month',
        ];
    }

    /**
     * @return array
     */
    public function getMonthsOptions()
    {
        $months = [];
        $now = new \DateTime();

        for ($i = 1; $i <= 12; $i++) {
            $now->setDate($now->format('Y'), $i, 1);
            $months[$i] = $now->format('M');
        }

        return $months;
    }

    /**
     * @return array
     */
    public function getHumanizedMonthsOptions()
    {
        return [
            '*'      => 'Every month',
            '*/2'    => 'Even months',
            '1-11/2' => 'Odd months',
            '*/4'    => 'Every 4 months',
            '*/6'    => 'Every half year'
        ];
    }

    /**
     * @return array
     */
    public function getWeekdaysOptions()
    {
        $weekdays = [];
        $now = new \DateTime();
        $now->modify("-{$now->format('w')} days");

        for ($i = 0; $i < 7; $i++) {
            $weekdays[$i] = $now->format('D');
            $now->modify("+1 day");
        }

        return $weekdays;
    }

    /**
     * @return array
     */
    public function getHumanizedWeekdaysOptions()
    {
        return [
            '*'   => 'Every Weekday',
            '1-5' => 'Monday-Friday',
            '0,6' => 'Weekend days'
        ];
    }

    /**
     * @param $expression
     * @return Carbon
     */
    public function parseExpressionToNextDate($expression, $isFromCron = false)
    {
        list($minutes, $hours, $days, $months, $weekdays) = explode(" ", $expression);
        $now = Carbon::now();

        if ($isFromCron) {
            $now->addMinute();
        }

        $now->setTime($now->hour, $now->minute, 0);
        $isValidDate = false;

        $checkedMonth = -1;
        $checkedDay = -1;
        $checkedWeekday = -1;
        $checkedHour = -1;

        info($now->format('Y-m-d H:i:s'));

        while (!$isValidDate) {
            if ($checkedMonth === $now->month or $this->months($now, $months)) {
                $checkedMonth = $now->month;

                if ($checkedDay === $now->day or $this->days($now, $days)) {
                    $checkedDay = $now->day;

                    if ($checkedWeekday === $now->dayOfWeek or $this->weekdays($now, $weekdays)) {
                        $checkedWeekday = $now->dayOfWeek;

                        if ($checkedHour === $now->hour or $this->hours($now, $hours)) {
                            $checkedHour = $now->hour;

                            if ($this->minutes($now, $minutes)) {
                                $isValidDate = true;
                                $now->setTime($now->hour, $now->minute, 0);
                            } else {
                                $nextValue = $this->getNextAvailableRange($now->minute, $minutes, 0, 59);

                                if ($nextValue > $now->minute) {
                                    $now->setTime($now->hour, $nextValue);
                                } else {
                                    $now->addHour();
                                    $now->setTime($now->hour, 0);
                                }
                            }
                        } else {
                            $nextValue = $this->getNextAvailableRange($now->hour, $hours, 0, 23);

                            if ($nextValue > $now->hour) {
                                $now->setTime($nextValue, 0);
                            } else {
                                $now->addDay();
                                $now->setTime(0, 0);
                            }
                        }
                    } else {
                        $nextValue = $this->getNextAvailableRange($now->dayOfWeek, $weekdays, 0, 6);

                        if ($nextValue > $now->dayOfWeek) {
                            $nextValue = $nextValue - $now->dayOfWeek;
                        } else {
                            $diffWeek = 6 - $now->dayOfWeek;
                            $nextValue += $diffWeek;
                        }

                        $now->addDays($nextValue);
                        $now->setTime(0, 0);
                    }
                } else {
                    $lastDate = Carbon::createFromFormat('Y-m-d H:i:s', $now->format('Y-m-d H:i:s'));
                    $nextValue = $this->getNextAvailableRange($now->day, $days, 1, $lastDate->lastOfMonth()->day);

                    if ($nextValue > $now->day) {
                        $now->setDate($now->year, $now->month, $nextValue);
                        $now->setTime(0, 0);
                    } else {
                        $now->addMonth();
                        $now->setDateTime($now->year, $now->month, 1, 0, 0);
                    }
                }
            } else {
                $nextValue = $this->getNextAvailableRange($now->month, $months, 1, 12);

                if ($nextValue > $now->month) {
                    $nextValue = $nextValue - $now->month;
                } else {
                    $diffWeek = 12 - $now->month;
                    $nextValue += $diffWeek;
                }

                $now->addMonths($nextValue);
                $now->setDateTime($now->year, $now->month, 1, 0, 0);
            }
        }

        $now->setTime($now->hour, $now->minute, 0);
        return $now;
    }

    /**
     * @param $currentValue
     * @param $delimiter
     * @param $start
     * @param $end
     * @return mixed
     */
    private function getNextAvailableRange($currentValue, $delimiter, $start, $end)
    {
        $values = $this->getAvailableValues($delimiter, $start, $end);
        $tmpValue = $values[0];

        foreach ($values as $value) {
            if ($value > $currentValue) {
                $tmpValue = $value;
                break;
            }
        }

        return $tmpValue;
    }

    /**
     * @param $delimiter
     * @param $start
     * @param $end
     * @return array
     */
    public function getAvailableValues($delimiter, $start, $end)
    {
        $parsedArray = [];

        if (str_contains($delimiter, "/")) {
            list($a, $b) = explode("/", $delimiter);

            if (!str_contains($a, "*")) {
                if (str_contains($a, "-")) {
                    list($c, $d) = explode("-", $a);

                    if ($c > $start) {
                        $start = $c;
                    }
                    if ($d < $end) {
                        $end = $d;
                    }
                } else {
                    if ($a > $start) {
                        $start = $a;
                    }
                }
            }

            for ($i = $start; $i <= $end; $i += $b) {
                $parsedArray[] = (int)$i;
            }
        } else {
            $elements = explode(",", $delimiter);

            foreach ($elements as $element) {
                if (str_contains($element, "-")) {
                    list($c, $d) = explode("-", $element);

                    if ($c < $start) {
                        $c = $start;
                    }

                    if ($d > $end) {
                        $d = $end;
                    }

                    for ($i = $c; $i <= $d; $i++) {
                        $parsedArray[] = (int)$i;
                    }
                } else {
                    if ($element < $start) {
                        $element = $start;
                    }
                    if ($element > $end) {
                        $element = $end;
                    }

                    $parsedArray[] = (int)$element;
                }


            }
        }

        return $parsedArray;
    }

    /**
     * @param Carbon $date
     * @param $delimiter
     * @return bool
     */
    private function hours(\Carbon\Carbon $date, $delimiter)
    {
        if ($delimiter !== "*") {
            $hour = $date->format('G');
            return in_array($hour, $this->getAvailableValues($delimiter, 0, 23));
        }

        return true;
    }

    /**
     * @param Carbon $date
     * @param $delimiter
     * @return bool
     */
    private function minutes(\Carbon\Carbon $date, $delimiter)
    {
        if ($delimiter !== "*") {
            $minutes = (int)$date->format('i');
            return in_array($minutes, $this->getAvailableValues($delimiter, 0, 59));
        }

        return true;
    }

    /**
     * @param Carbon $date
     * @param $delimiter
     * @return bool
     */
    private function days(\Carbon\Carbon $date, $delimiter)
    {

        if ($delimiter !== "*") {
            $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'));
            $day = $date->format('j');
            return in_array($day, $this->getAvailableValues($delimiter, 1, $carbon->lastOfMonth()->day));
        }

        return true;
    }

    /**
     * @param Carbon $date
     * @param $delimiter
     * @return bool
     */
    private function months(\Carbon\Carbon $date, $delimiter)
    {
        if ($delimiter !== "*") {
            $month = $date->format('n');
            return in_array($month, $this->getAvailableValues($delimiter, 1, 12));
        }

        return true;
    }

    /**
     * @param Carbon $date
     * @param $delimiter
     * @return bool
     */
    private function weekdays(\Carbon\Carbon $date, $delimiter)
    {
        if ($delimiter !== "*") {
            $weekday = $date->format('w');
            return in_array($weekday, $this->getAvailableValues($delimiter, 0, 6));
        }

        return true;
    }

    /**
     * @param $item
     * @return array|mixed|string
     */
    public function getSelectedItem($item, array $data)
    {
        if ($data[$item] === 'on') {
            $selectField = str_replace("-select", "", $item);
            return $this->parseMultipleSelect($data[$selectField]);
        }
        return $data[$item];
    }

    /**
     * @param array $data
     * @return mixed
     */
    private function getParsedExpression(array $data)
    {
        $matches = array_filter($data, function ($item, $dataKey) {
            return preg_match('/(\w+)(\-select)$/', $dataKey) === 1;
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($matches as $type => $item) {
            $index = $this->getOrderedIndexByType($type);

            $parsed[$index] = $this->getSelectedItem($type, $data);
        }

        return $parsed;
    }
}