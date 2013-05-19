<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Reader\ICal;

use CollabCalendar\Entity\Calendar;
use CollabCalendar\Entity\Event;
use CollabCalendar\Entity\Property;
use CollabCalendar\Reader\ReaderInterface;
use DateTime;

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
                    
                    case 'VTIMEZONE':
                        $this->parseTill($lines, 'END:VTIMEZONE');
                        break;
                    
                    case 'DAYLIGHT':
                        $this->parseTill($lines, 'END:DAYLIGHT');
                        break;
                    
                    case 'STANDARD':
                        $this->parseTill($lines, 'END:STANDARD');
                        break;

                    default:
                        throw new \RuntimeException('Type not supported: ' . $line);
                }
            } else {
				switch ($property->getName()) {
					case 'X-WR-CALNAME':
						$calendar->setTitle($property->getValue());
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
                    $dateTime = $this->parseDateTime($property);
                    $event->setStartDate($dateTime);
					break;
				
				case 'DTEND':
                    $dateTime = $this->parseDateTime($property);
                    $event->setEndDate($dateTime);
					break;
				
				default:
					$event->setProperty($property);
					break;
			}
        }
    }

    public function parseProperty($text)
    {
        $result = null;
        if (preg_match('/(?<name>.+?)(?:;(?<param>.+?))?:(?<value>.*)/i', $text, $matches)) {
            $params = array();
            if ($matches['param']) {
                $splitted = explode(';', $matches['param']);
                foreach ($splitted as $param) {
                    list($name, $value) = explode('=', $param, 2);
                    
                    $params[$name] = $value;
                }
            }
            
			$result = new Property($matches['name'], $matches['value'], $params);
		}
        return $result;
    }

    public function parseDateTime(Property $property)
    {
        $result = new DateTime();
        $result->setTimestamp(strtotime($property->getValue()));
        if ($property->hasParam('TZID')) {
            $dateTimeZone = new \DateTimeZone($property->getParam('TZID'));
            $result->setTimezone($dateTimeZone);
        }
        return $result;
    }

    public function parseTill($lines, $end)
    {
        while (count($lines)) {
            $line = trim(array_shift($lines));

            if ($line == $end) {
                break;
            }
        }
    }
}
