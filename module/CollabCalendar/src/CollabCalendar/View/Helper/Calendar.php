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
    public function __invoke()
    {
        $result = '';

        $today = new DateTime('this month');

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

        $result .= '<table class="calendar month">';
        $result .= '<tr>';
        $result .= '<th><div>Mon</div></th>';
        $result .= '<th><div>Tue</div></th>';
        $result .= '<th><div>Wed</div></th>';
        $result .= '<th><div>Thu</div></th>';
        $result .= '<th><div>Fri</div></th>';
        $result .= '<th><div>Sat</div></th>';
        $result .= '<th><div>Sun</div></th>';
        $result .= '</tr>';

        for ($r = 0; $r < $totalRows; ++$r) {
            $result .= '<tr>';
            for ($c = 0; $c < 7; ++$c) {
                $day = ($r * 7 + $c - $startIndex + 1);

                $classes = array();

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

                $result .= '<td class="' . implode(' ', $classes) . '"><div>' . $day . '</div></td>';
            }
            $result .= '</tr>';
        }

        $result .= '</table>';

        return $result;
    }
}
