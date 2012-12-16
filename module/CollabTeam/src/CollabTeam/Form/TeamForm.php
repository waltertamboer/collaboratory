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

use CollabTeam\Form\Hydrator\TeamMembersStrategy;
use CollabTeam\Form\Hydrator\TeamPermissionsStrategy;
use CollabTeam\Form\Hydrator\TeamProjectsStrategy;
use CollabTeam\InputFilter\TeamInputFilter;
use DoctrineORMModule\Form\Element\EntityMultiCheckbox;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element\Collection;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class TeamForm extends Form implements InputFilterProviderInterface
{
    public function __construct($userService, $permissionsService, $projectsService)
    {
        parent::__construct('team');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setInputFilter(new TeamInputFilter());

        $name = new Text('name');
        $name->setLabel('Team name');
        $this->add($name);

        $description = new Textarea();
        $description->setName('description');
        $description->setLabel('Description');
        $this->add($description);

        $permissions = new EntityMultiCheckbox();
        $permissions->setName('permissions');
        $this->add($permissions);

        $members = new Collection();
        $members->setName('members');
        $members->setLabel('Members');
        $members->setAllowAdd(true);
        $members->setShouldCreateTemplate(false);
        $members->setTargetElement(array(
            'type' => 'CollabTeam\Form\Fieldset\TeamMemberFieldset'
        ));
        $this->add($members);

        $projects = new Collection();
        $projects->setName('projects');
        $projects->setLabel('Projects');
        $projects->setAllowAdd(true);
        $projects->setShouldCreateTemplate(false);
        $projects->setTargetElement(array(
            'type' => 'CollabTeam\Form\Fieldset\TeamProjectFieldset'
        ));
        $this->add($projects);

        $save = new Text('save');
        $save->setLabel('Save');
        $save->setValue('Save');
        $this->add($save);

        $hydrator = $this->getHydrator();
        $hydrator->addStrategy('members', new TeamMembersStrategy($userService));
        $hydrator->addStrategy('permissions', new TeamPermissionsStrategy($permissionsService));
        $hydrator->addStrategy('projects', new TeamProjectsStrategy($projectsService));

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
            'description' => array(
                'required' => true,
            ),
            'permissions' => array(
                'required' => false,
            ),
            'members' => array(
                'required' => false,
            ),
            'projects' => array(
                'required' => false,
            ),
            'permissions' => array(
                'required' => false,
            ),
        );
    }

}
