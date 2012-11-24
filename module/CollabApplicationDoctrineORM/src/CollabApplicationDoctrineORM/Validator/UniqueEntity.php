<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplicationDoctrineORM\Validator;

use CollabApplication\Validator\AbstractUnique;
use Doctrine\ORM\EntityManager;

class UniqueEntity extends AbstractUnique
{
    private $entityManager;
    private $entityClass;
    private $field;
    private $method;

    public function __construct(EntityManager $entityManager, $entityClass, $field, $method)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $this->field = $field;
        $this->method = $method;
    }

    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    public function checkValue($value)
    {
        $repository = $this->entityManager->getRepository($this->entityClass);

        $entity = $repository->findOneBy(array(
            $this->field => $value
        ));

        $result = true;
        if ($entity) {
            $method = $this->method;
            $result = in_array($entity->$method(), $this->getExceptions());
        }
        return $result;
    }

}
