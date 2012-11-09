<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
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

        $result .= '<table>';
        $result .= '<tr>';
        $result .= '<th>Mon</th>';
        $result .= '<th>Tue</th>';
        $result .= '<th>Wed</th>';
        $result .= '<th>Thu</th>';
        $result .= '<th>Fri</th>';
        $result .= '<th>Sat</th>';
        $result .= '<th>Sun</th>';
        $result .= '</tr>';

        $lastDayPrevMonth = new DateTime('last day of previous month');

        $today = new DateTime();
        $totalDays = $today->format('t');
        $totalRows = ceil($totalDays / 7);

        $firstDay = new DateTime('first day of this month');
        $startIndex = $firstDay->format('N') - 1;

        for ($r = 0; $r < $totalRows; ++$r) {
            $result .= '<tr>';
            for ($c = 0; $c < 7; ++$c) {
                $day = ($r * 7 + $c - $startIndex + 1);

                if ($day < 1) {
                    $day = $lastDayPrevMonth->format('t') + $day . ' (prev)';
                } elseif ($day > $totalDays) {
                    $day -= $totalDays;
                    $day .= ' (next)';
                } elseif ($day == $today->format('d')) {
                    $day .= ' (today)';
                }

                $result .= '<td>' . $day . '</td>';
            }
            $result .= '</tr>';
        }

        $result .= '</table>';

        return $result;
    }
}
