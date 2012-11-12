<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceManager;

class AccountInputFilter extends InputFilter
{
    public function __construct()
    {
        $identity = new Input();
        $identity->setName('identity');
        $identity->setRequired(true);
        $identity->getValidatorChain()->addByName('EmailAddress');
        $this->add($identity);

        $credential = new Input();
        $credential->setName('credential');
        $credential->setRequired(true);
        $credential->getValidatorChain()->addByName('StringLength', array(
           'min' => 6
        ));
        $credential->getFilterChain()->attachByName('StringTrim');
        $this->add($credential);

        $validation = new Input();
        $validation->setName('validation');
        $validation->setRequired(true);
        $validation->getValidatorChain()->addByName('Identical', array(
           'token' => 'credential'
        ));
        $this->add($validation);

        $displayName = new Input();
        $displayName->setName('displayName');
        $displayName->setRequired(false);
        $this->add($displayName);
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $serviceName = 'collabuser.identityvalidator';

        if ($serviceManager->has($serviceName)) {
            $validator = $serviceManager->get($serviceName);

            $identity = $this->get('identity');
            $identity->getValidatorChain()->addValidator($validator);
        }
    }
}
