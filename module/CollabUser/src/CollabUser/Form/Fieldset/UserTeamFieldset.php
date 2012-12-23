<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Form\Fieldset;

use CollabTeam\Entity\Team;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UserTeamFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('userTeam');

        $this->setLabel('Team');
        $this->setObject(new Team());
        $this->setHydrator(new ClassMethodsHydrator(false));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false,
            ),
            'name' => array(
                'required' => false,
            )
        );
    }
}
