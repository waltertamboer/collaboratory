<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Calendar\Reader\ICal;

use CollabCalendar\Calendar\Calendar;
use CollabCalendar\Calendar\Event;
use CollabCalendar\Calendar\Property;
use CollabCalendar\Calendar\Reader\ReaderInterface;

// http://www.kanzaki.com/docs/ical/vtodo.html
// http://www.kanzaki.com/docs/ical/vevent.html
// http://www.kanzaki.com/docs/ical/vtimezone.html
class Reader implements ReaderInterface
{
	private $url;
	
	public function setUrl($url)
	{
		$this->url = $url;
	}
	
	public function read()
	{
		return $this->readFromUrl($this->url);
	}
	
    public function readFromUrl($url)
    {
        $lines = file($url, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
				switch ($property->getName()) {
					case 'X-WR-CALNAME':
						$calendar->setName($property->getValue());
						break;
					
					default:
						$calendar->setProperty($property);
						break;
				}
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
			switch ($property->getName()) {
				case 'SUMMARY':
					$event->setTitle($property->getValue());
					break;
				
				case 'SUMMARY':
					$event->setTitle($property->getValue());
					break;
				
				case 'DESCRIPTION':
					$event->setDescription($property->getValue());
					break;
				
				case 'DTSTART':
					var_dump($line);
					break;
				
				default:
					$event->setProperty($property);
					break;
			}
        }
		var_dumP($event);
    }

    public function parseProperty($text)
    {
        $result = null;
        if (preg_match('/(?<name>.+?)(?:;(?<param>.+?))?:(?<value>.*)/i', $text, $matches)) {
			$result = new Property($matches['name'], $matches['value'], $matches['param']);
		}
        return $result;
    }
}
