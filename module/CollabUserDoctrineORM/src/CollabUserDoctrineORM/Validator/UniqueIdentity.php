<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUserDoctrineORM\Validator;

use Doctrine\ORM\EntityManager;
use Zend\Validator\AbstractValidator;

class UniqueIdentity extends AbstractValidator
{
    const ERROR_OBJECT_FOUND = 'identityExists';

    protected $messageTemplates = array(
        self::ERROR_OBJECT_FOUND => "The identity '%value%' already exists",
    );

    private $entityManager;
    private $exceptValues;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();
        
        $this->entityManager = $entityManager;
        $this->exceptValues = array();
    }

    public function addException($value)
    {
        $this->exceptValues[] = $value;
    }

    public function isValid($value)
    {
        $repository = $this->entityManager->getRepository('CollabUser\Entity\User');

        $entity = $repository->findOneBy(array(
            'identity' => $value
        ));

        $result = true;
        if ($entity) {
            $result = in_array($entity->getIdentity(), $this->exceptValues);
        }
        if (!$result) {
            $this->error(self::ERROR_OBJECT_FOUND, $value);
        }
        return $result;
    }

}
