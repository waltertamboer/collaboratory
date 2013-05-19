<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Entity;

use CollabUser\Entity\User;
use DateTime;

interface EventInterface
{
    public function getCalendar();
    public function setCalendar(Calendar $calendar);
    
	public function getTitle();
	public function setTitle($title);
	
	public function getDescription();
	public function setDescription($description);
    
	public function getStartDate();
	public function setStartDate($startDate);
    
	public function getEndDate();
	public function setEndDate($startDate);
    
	public function getCreatedBy();
	public function setCreatedBy(User $user);
    
	public function getCreatedOn();
	public function setCreatedOn($startDate);
    
    public function occurs(DateTime $date);
    public function occursOnDay(DateTime $date);
    public function occursInMonth(DateTime $date);
    public function occursInYear(DateTime $date);
}
