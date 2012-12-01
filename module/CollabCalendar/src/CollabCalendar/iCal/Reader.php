<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\iCal;

// http://www.kanzaki.com/docs/ical/vtodo.html
// http://www.kanzaki.com/docs/ical/vevent.html
// http://www.kanzaki.com/docs/ical/vtimezone.html
class Reader
{
    public function readFromUrl($path)
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!count($lines) || stristr($lines[0], 'BEGIN:VCALENDAR') === false) {
            return false;
        }

        return $this->readFromStringArray($lines);
    }

    private function readFromStringArray($lines)
    {
        $calendar = new Calendar();

        $line = array_shift($lines);
        switch ($line) {
            case 'BEGIN:VCALENDAR':
                $this->parseCalendar($calendar, $lines);
                break;

            default:
                throw new \RuntimeException('Invalid calendar format!');
        }

        return $calendar;
    }

    private function parseCalendar(Calendar $calendar, $lines)
    {
        $type = null;
        while (count($lines)) {
            $line = trim(array_shift($lines));

            $property = $this->parseProperty($line);
            if (!$property) {
                throw new \RuntimeException('No property found in line: ' . $line);
            }

            if (preg_match('/^BEGIN:([a-z]+)$/i', $line, $matches)) {
                switch ($matches[1]) {
                    case 'VEVENT':
                        $this->parseEvent($calendar, $lines);
                        break;

                    default:
                        throw new \RuntimeException('Type not supported: ' . $line);
                }
            } else {
                $calendar->setProperty($property->getName(), $property->getValue());
            }
        }
    }

    private function parseEvent(Calendar $calendar, $lines)
    {
        $event = new Event();
        $calendar->addEvent($event);

        while (count($lines)) {
            $line = trim(array_shift($lines));

            if ($line == 'END:VEVENT') {
                break;
            }

            $property = $this->parseProperty($line);
            $event->setProperty($property->getName(), $property->getValue());
        }
    }

    public function parseProperty($text)
    {
        $result = null;
        if (preg_match("/([^:]+)[:]([\w\W]*)/", $text, $matches)) {
            $matches = array_splice($matches, 1, 2);

            $result = new Property($matches[0], $matches[1]);
        }
        return $result;
    }
}
