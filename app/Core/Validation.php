<?php


namespace App\Core;


class Validation
{
    public static function bankHoliday(string $date, array $bankHolidays):bool
    {
        if(!empty($bankHolidays))
        {
            foreach ($bankHolidays as $holiday)
            {
                if($date === $holiday)
                {
                    return true;
                }
            }return false;
        }return false;

    }

    public static function weekend (\DateTime $date):bool
    {
        $name = date_format($date,"D");
        if($name === 'Sat'|| $name === 'Sun')
        {
            return true;
        }return false;
    }


}