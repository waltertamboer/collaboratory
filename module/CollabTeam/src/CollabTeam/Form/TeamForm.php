<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam\Form;

use CollabTeam\Form\Fieldset\TeamFieldset;
use CollabTeam\InputFilter\TeamInputFilter;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class TeamMembersStrategy implements \Zend\Stdlib\Hydrator\Strategy\StrategyInterface
{
    private $userService;

    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    public function extract($value)
    {
        return $value;
    }

    public function hydrate($value)
    {
        $result = $value;
        if (is_array($value)) {
            $result = array();
            foreach ($value as $member) {
                $result[] = $this->userService->findById($member->getId());
            }
        }
        return $result;
    }
}

class TeamProjectsStrategy implements \Zend\Stdlib\Hydrator\Strategy\StrategyInterface
{
    private $projectsService;

    public function __construct($userService)
    {
        $this->projectsService = $userService;
    }

    public function extract($value)
    {
        return $value;
    }

    public function hydrate($value)
    {
        $result = $value;
        if (is_array($value)) {
            $result = array();
            foreach ($value as $entity) {
                $result[] = $this->projectsService->getById($entity->getId());
            }
        }
        return $result;
    }
}

class TeamForm extends Form
{
    public function __construct($userService, $projectsService)
    {
        parent::__construct('team');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new TeamInputFilter());

        $fieldset = new TeamFieldset();
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);

        $hydrator = $fieldset->getHydrator();
        $hydrator->addStrategy('members', new TeamMembersStrategy($userService));
        $hydrator->addStrategy('projects', new TeamProjectsStrategy($projectsService));

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $this->add($submitButton);
    }
}
