<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\View\Helper;

use DateTime;
use Zend\View\Helper\AbstractHelper;

class Calendar extends AbstractHelper
{
    public function __invoke($options)
    {
        $result = '';
        
        $today = new DateTime('this month');
        $year = array_key_exists('year', $options) ? $options['year'] : $today->format('Y');
        $month = array_key_exists('month', $options) ? $options['month'] : $today->format('n');
        $day = array_key_exists('day', $options) ? $options['day'] : $today->format('j');
        $today->setDate($year, $month, $day);

        $lastDayPrevMonth = clone $today;
        $lastDayPrevMonth->modify('last day of previous month');

        $nextMonth = clone $today;
        $nextMonth->modify('+1 month');

        $firstDay = clone $today;
        $firstDay->modify('first day of this month');
        $startIndex = $firstDay->format('N') - 1;

        $totalDays = $today->format('t');
        $totalRows = ceil(($totalDays + $startIndex) / 7);

        echo '<h2>' . $today->format('F Y') . '</h2>';

        $result .= '<div class="calendar">' . PHP_EOL;
        $result .= "\t" . '<div class="calendar-row calendar-header">' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Mon</div>' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Tue</div>' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Wed</div>' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Thu</div>' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Fri</div>' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Sat</div>' . PHP_EOL;
        $result .= "\t\t" . '<div class="calendar-column">Sun</div>' . PHP_EOL;
        $result .= "\t" . '</div>' . PHP_EOL;

        for ($r = 0; $r < $totalRows; ++$r) {
            $result .= "\t" . '<div class="calendar-row">' . PHP_EOL;
            for ($c = 0; $c < 7; ++$c) {
                $day = ($r * 7 + $c - $startIndex + 1);

                $classes = array('calendar-column');

                if ($day < 1) {
                    $day = $lastDayPrevMonth->format('t') + $day;
                    $classes[] = 'previous';

                    if ($day == 1) {
                        $day .= $lastDayPrevMonth->format(' M');
                    }
                } elseif ($day > $totalDays) {
                    $day -= $totalDays;
                    $classes[] = 'next';

                    if ($day == 1) {
                        $day .= $nextMonth->format(' M');
                    }
                } else {
                    if ($day == $today->format('d')) {
                        $classes[] = 'today';
                    } else {
                        $classes[] = 'current';
                    }

                    if ($day == 1) {
                        $day .= $today->format(' M');
                    }
                }
                
                $result .= "\t\t" . '<div class="' . implode(' ', $classes) . '">' . $day . '</div>' . PHP_EOL;
            }
            $result .= "\t" . '</div>' . PHP_EOL;
        }

        $result .= '</div>' . PHP_EOL;
        
        return $result;
    }
}