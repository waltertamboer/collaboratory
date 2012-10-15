<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application\Form;

use Application\Entity\Team as TeamEntity;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Form\Element\Collection;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class TeamMember
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}

class TeamMemberFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('teamMember');
        $this->setHydrator(new ClassMethodsHydrator(false))->setObject(new TeamMember());

        $this->setLabel('Member');

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name'
            ),
            'attributes' => array(
                'type' => 'text'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            )
        );
    }
}

class TeamFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('team');

        $this->setHydrator(new ClassMethodsHydrator(false))->setObject(new TeamEntity());

        $name = new Text('name');
        $name->setLabel('Team name');
        $this->add($name);

        $description = new Textarea();
        $description->setName('description');
        $description->setLabel('Description');
        $this->add($description);

        $permissions = new MultiCheckbox();
        $permissions->setName('permissions');
        $permissions->setValueOptions(array(
            'Can create teams',
            'Can delete teams',
            'Can create projects',
            'Can delete projects',
            'Can create issues',
            'Can delete issues',
        ));
        $this->add($permissions);

        $members = new Collection();
        $members->setName('members');
        $members->setLabel('Members');
        $members->setAllowAdd(true);
        $members->setCount(3);
        $members->setShouldCreateTemplate(true);
        $members->setTargetElement(array(
            'type' => 'Application\Form\TeamMemberFieldset'
        ));
        $this->add($members);
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
        );
    }
}

class Team extends Form
{
    private $serviceManager;

    public function __construct()
    {
        parent::__construct('team');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $fieldset = new TeamFieldset();
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $this->add($submitButton);
    }
}
