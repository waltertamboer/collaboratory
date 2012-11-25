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
use CollabTeam\Form\Hydrator\TeamMembersStrategy;
use CollabTeam\Form\Hydrator\TeamPermissionsStrategy;
use CollabTeam\Form\Hydrator\TeamProjectsStrategy;
use CollabTeam\InputFilter\TeamInputFilter;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class TeamForm extends Form
{
    public function __construct($userService, $permissionsService, $projectsService)
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
        $hydrator->addStrategy('permissions', new TeamPermissionsStrategy($permissionsService));
        $hydrator->addStrategy('projects', new TeamProjectsStrategy($projectsService));

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $this->add($submitButton);
    }
}
