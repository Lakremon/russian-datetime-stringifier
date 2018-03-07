<?php

namespace russianDateHelper;

/**
 * Class russianDateHelper - main helper class
 * @package russianDateHelper
 */
class russianDateHelper
{
    protected static $_countOfPeriods = 2;

    /**
     * Set how match count of periods show in result string
     * @param $countOfPeriodValue
     */
    public static function __setCountOfPeriods($countOfPeriodValue)
    {
        if (!is_integer($countOfPeriodValue)) {
            // TODO add wrong property type exception
        }
        if ($countOfPeriodValue < 1 || $countOfPeriodValue > 7) {
            // TODO add wrong period number exception
        }
        self::$_countOfPeriods = $countOfPeriodValue;
    }

    /**
     * Get time period as count of seconds and return user-friendly period format
     * @param $periodInSeconds integer
     * @return string
     */
    public static function timeToPeriod($periodInSeconds)
    {
        if (!is_integer($periodInSeconds)) {
            // TODO add wrong property type exception
        }
        $result = '';
        $periodsTomes = [
                'year' => 365 * 24 * 60 * 60,
                'month' => 30 * 24 * 60 * 60,
                'week' => 7 * 24 * 60 * 60,
                'day' => 24 * 60 * 60,
                'hour' => 60 * 60,
                'minute' => 60,
                'second' => 1,
        ];
        $periodNames = [
                'year' => ['год', 'года', 'лет'],
                'month' => ['месяц', 'месяца', 'месяцев'],
                'week' => ['неделя', 'недели', 'недель'],
                'day' => ['день', 'дня', 'дней'],
                'hour' => ['час', 'часа', 'часов'],
                'minute' => ['минута', 'минуты', 'минут'],
                'second' => ['секунда', 'секунды', 'секунд'],
        ];

        $i = 0;
        foreach ($periodsTomes as $periodKey => $periodValue) {
            if ($i < self::$_countOfPeriods) {
                $currentPeriodValue = floor($periodInSeconds / $periodValue);
                if ($currentPeriodValue) {
                    $result .= $currentPeriodValue . ' ';
                    if ($currentPeriodValue % 10 > 4) {
                        $result .= $periodNames [$periodKey][2];
                    } elseif ($currentPeriodValue % 10 == 1 && ($currentPeriodValue % 100 < 10 || $currentPeriodValue % 100 > 20)) {
                        $result .= $periodNames [$periodKey][0];
                    } else {
                        $result .= $periodNames [$periodKey][1];
                    }
                    $periodInSeconds %= $periodValue;
                    $i++;
                    $result .= $i == self::$_countOfPeriods ? '.' : ' ';
                }
            } else {
                break;
            }
        }
        return $result;
    }
}