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

use CollabUser\InputFilter\AccountInputFilter;
use Zend\Form\Element\Collection;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UserTeamsStrategy implements \Zend\Stdlib\Hydrator\Strategy\StrategyInterface
{
    private $teamService;

    public function __construct($teamService)
    {
        $this->teamService = $teamService;
    }

    public function extract($value)
    {
        return $value;
    }

    public function hydrate($value)
    {
        $result = $value;
        if (is_array($value)) {
            $result = array();
            var_dump($value);exit;
            foreach ($value as $entity) {
                $result[] = $this->teamService->getById($entity->getId());
            }
        }
        return $result;
    }
}

class AccountForm extends Form
{
    public function __construct($teamService)
    {
        parent::__construct('profile');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setInputFilter(new AccountInputFilter());

        $hydrator = $this->getHydrator();
        $hydrator->addStrategy('teams', new UserTeamsStrategy($teamService));

        $identity = new Text('identity');
        $identity->setLabel('Identity');
        $this->add($identity);

        $credential = new Password('credential');
        $credential->setLabel('Credential');
        $this->add($credential);

        $validation = new Password('validation');
        $validation->setLabel('(Validation)');
        $this->add($validation);

        $displayName = new Text('displayName');
        $displayName->setLabel('Display name');
        $this->add($displayName);

        $teams = new Collection();
        $teams->setName('teams');
        $teams->setLabel('Teams');
        $teams->setAllowAdd(true);
        $teams->setShouldCreateTemplate(true);
        $teams->setTargetElement(array(
            'type' => 'CollabUser\Form\Fieldset\UserTeamFieldset'
        ));
        $this->add($teams);

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
