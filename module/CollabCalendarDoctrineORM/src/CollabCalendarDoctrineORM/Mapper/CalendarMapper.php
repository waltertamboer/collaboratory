<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendarDoctrineORM\Mapper;

use CollabCalendar\Entity\Calendar;
use CollabCalendar\Mapper\CalendarMapperInterface;
use Doctrine\ORM\EntityManager;

class CalendarMapper implements ProjectMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(Calendar $calendar)
    {
        $this->entityManager->persist($calendar);
        $this->entityManager->flush();

        return $this;
    }

    public function remove(Calendar $calendar)
    {
        $this->entityManager->remove($calendar);
        $this->entityManager->flush();

        return $this;
    }
}
