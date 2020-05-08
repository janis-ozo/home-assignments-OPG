<?php

namespace App\Core;

class Calculate
{

    public static function endDate(string $startDate, array $points ,int $humanPower,array $bankHolidays): string
    {
        $durationInDays = (round(array_sum($points)/$humanPower))/8;
        $durationWithHolidays = Calculate::durationWithHolidays($startDate,$durationInDays,$bankHolidays);

        $date = date_create(date('Y-m-d', strtotime($startDate . " + " . ($durationWithHolidays - 1) . " days")));
        return date_format($date, 'Y-m-d');
    }

    public static function durationWithHolidays(string $startDate, int $durationInDays, array $bankHolidays): int
    {
        $holidays = 0;
        $countdown = 0;
        for ($i = 0; $i < $durationInDays; $i++) {
            $date = date_create(date('Y-m-d', strtotime($startDate . ' + ' . $i . ' days')));
            $currentDate = date_format($date, 'Y-m-d');


            if (Validation::weekend($date)) {
                $holidays++;
                $countdown++;


                if ($countdown === 6) {
                    $holidays = $holidays + 2;
                    $countdown = 0;
                }
            } elseif (Validation::bankHoliday($currentDate, $bankHolidays)) {
                if (!Validation::weekend($date)) {
                    $holidays++;
                    $countdown++;

                    if ($countdown === 6) {
                        $holidays = $holidays + 2;
                        $countdown = 0;
                    }
                }

            }
        }
        return $durationInDays + $holidays;
    }

    public static function points (float $unitVal, float $koef):float
    {
        return $unitVal * $koef;
    }
}

