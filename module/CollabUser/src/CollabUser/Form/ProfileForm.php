<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Form;

use CollabUser\InputFilter\ProfileInputFilter;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProfileForm extends Form
{
    public function __construct()
    {
        parent::__construct('profile');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setInputFilter(new ProfileInputFilter());

        $name = new Text('displayName');
        $name->setLabel('Display name');
        $this->add($name);

        $credential = new Password('credential');
        $credential->setLabel('Credential');
        $this->add($name);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }
}
