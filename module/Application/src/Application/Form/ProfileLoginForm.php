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

use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProfileLoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false));

        $password = new Password('password');
        $password->setLabel('Password');
        $this->add($password);

        $validation = new Password('validation');
        $validation->setLabel('(validation)');
        $this->add($validation);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }
}
