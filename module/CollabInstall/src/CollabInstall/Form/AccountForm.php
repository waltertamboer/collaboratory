<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall\Form;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ArraySerializable;

class AccountForm extends Form
{
    public function __construct()
    {
        parent::__construct('account');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ArraySerializable());

        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $identity = new Input();
        $identity->setName('identity');
        $identity->setRequired(true);
        $identity->getValidatorChain()->addByName('EmailAddress');
        $inputFilter->add($identity);

        $credential = new Input();
        $credential->setName('credential');
        $credential->setRequired(true);
        $credential->getValidatorChain()->addByName('StringLength', array(
           'min' => 6
        ));
        $credential->getFilterChain()->attachByName('StringTrim');
        $inputFilter->add($credential);

        $validation = new Input();
        $validation->setName('validation');
        $validation->setRequired(true);
        $validation->getValidatorChain()->addByName('Identical', array(
           'token' => 'credential'
        ));
        $inputFilter->add($validation);

        $displayName = new Input();
        $displayName->setName('displayName');
        $displayName->setRequired(true);
        $inputFilter->add($displayName);

        $element = new Text('identity');
        $element->setLabel('E-mail address:');
        $this->add($element);

        $element = new Password('credential');
        $element->setLabel('Credential');
        $this->add($element);

        $element = new Password('validation');
        $element->setLabel('(validation)');
        $this->add($element);

        $element = new Text('displayName');
        $element->setLabel('Display name');
        $this->add($element);

        $element = new Submit('save');
        $element->setLabel('Save');
        $element->setValue('Save');
        $this->add($element);
    }
}
