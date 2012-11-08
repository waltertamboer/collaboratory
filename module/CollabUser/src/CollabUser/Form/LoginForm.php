<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Form;

use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false));

        $identity = new Text('identity');
        $identity->setLabel('E-mail');
        $this->add($identity);

        $credential = new Password('credential');
        $credential->setLabel('Password');
        $this->add($credential);

        $submitButton = new Submit();
        $submitButton->setName('login');
        $submitButton->setValue('Login');
        $this->add($submitButton);
    }
}
