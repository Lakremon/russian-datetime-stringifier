<?php
namespace russianDateHelper;

use russianDateHelper\exception\DataTypeException;

/**
 * Class russianDateHelper - main helper class
 * @package russianDateHelper
 */
class RussianDateHelper
{
    protected static $_countOfPeriods = 2;

    const PERIODS_TOMES = [
        'year' => 365 * 24 * 60 * 60,
        'month' => 30 * 24 * 60 * 60,
        'week' => 7 * 24 * 60 * 60,
        'day' => 24 * 60 * 60,
        'hour' => 60 * 60,
        'minute' => 60,
        'second' => 1,
    ];

    const PERIODS_NAMES = [
        'year' => ['год', 'года', 'лет'],
        'month' => ['месяц', 'месяца', 'месяцев'],
        'week' => ['неделя', 'недели', 'недель'],
        'day' => ['день', 'дня', 'дней'],
        'hour' => ['час', 'часа', 'часов'],
        'minute' => ['минута', 'минуты', 'минут'],
        'second' => ['секунда', 'секунды', 'секунд'],
    ];

    /**
     * Convert \DateTime or \DatePeriod input var to integer
     * @param $data integer | \DatePeriod | \DateTime
     * @return $data integer
     */
    protected static function prepareData($data)
    {
        if (is_int($data)) {
            return $data;
        }
        if ($data instanceof \DatePeriod::$className){
            return $data;
        }
        if ($data instanceof \DatePeriod::$className){
            return $data;
        }

        throw new DataTypeException();
    }

    /**
     * Set how match count of periods show in result string
     * @param $countOfPeriodValue integer|\DateTime
     * @return $timeInSeconds integet
     */
    public static function setCountOfPeriods($countOfPeriodValue)
    {
        if (!is_integer($countOfPeriodValue)) {
            throw new DataTypeException();
        }
        if ($countOfPeriodValue < 1 || $countOfPeriodValue > 7) {
            // TODO add wrong period number exception
        }
        self::$_countOfPeriods = $countOfPeriodValue;
    }

    /**
     * Get time period as count of seconds and return user-friendly period format
     * @param $periodInSeconds integer|\DateTime
     * @return string
     */
    public static function getPerfectPeriod($period)
    {
        $periodInSeconds = self::prepareData($period);
        $result = '';

        $iteration = 0;
        foreach (self::PERIODS_TOMES as $periodKey => $periodValue) {
            if ($iteration < self::$_countOfPeriods) {
                $currentPeriodValue = floor($periodInSeconds / $periodValue);
                if ($currentPeriodValue) {
                    $result .= $currentPeriodValue . ' ';
                    if ($currentPeriodValue % 10 > 4) {
                        $result .= self::PERIODS_NAMES[$periodKey][2];
                    } elseif ($currentPeriodValue % 10 == 1 && ($currentPeriodValue % 100 < 10 || $currentPeriodValue % 100 > 20)) {
                        $result .= self::PERIODS_NAMES[$periodKey][0];
                    } else {
                        $result .= self::PERIODS_NAMES[$periodKey][1];
                    }
                    $periodInSeconds %= $periodValue;
                    $iteration++;
                    $result .= $iteration == self::$_countOfPeriods ? '.' : ' ';
                }
            } else {
                break;
            }
        }
        return trim($result);
    }
}