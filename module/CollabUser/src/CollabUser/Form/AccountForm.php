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

use CollabUser\InputFilter\AccountInputFilter;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class AccountForm extends Form
{
    public function __construct()
    {
        parent::__construct('profile');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setInputFilter(new AccountInputFilter());

        $identity = new Text('identity');
        $identity->setLabel('Identity');
        $this->add($identity);

        $credential = new Password('credential');
        $credential->setLabel('Credential');
        $this->add($credential);

        $validation = new Password('validation');
        $validation->setLabel('(Validation)');
        $this->add($validation);

        $name = new Text('displayName');
        $name->setLabel('Display name');
        $this->add($name);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->getInputFilter()->setServiceManager($serviceManager);
    }
}
