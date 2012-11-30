<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Form\Fieldset;

use CollabScm\Entity\RepositoryTeam;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class TeamFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('team');

        $this->setObject(new RepositoryTeam());
        $this->setHydrator(new ClassMethodsHydrator(false));

        $name = new Text('id');
        $name->setLabel('Id');
        $this->add($name);

        $name = new Select('permission');
        $name->setLabel('Permissions');
        $name->setValueOptions(array(
            'pull' => 'pull',
            'push' => 'push',
        ));
        $this->add($name);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => true,
            ),
            'permissions' => array(
                'required' => false,
            ),
        );
    }
}
