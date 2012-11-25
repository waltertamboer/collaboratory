<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Handler;

use CollabScm\Config\Config;
use CollabScm\Entity\Access;
use CollabScm\Entity\User;
use CollabScm\Entity\Group;
use CollabScm\Entity\Repository;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class ConfigSynchronizer implements ListenerAggregateInterface
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
    }

	public function create(Config $config)
	{
		$data = array();

		$data['groups'] = array();
		foreach ($config->getGroups() as $entity) {
			$data['groups'][] = array(
				'name' => $entity->getRawName(),
			);
		}

		$data['users'] = array();
		foreach ($config->getUsers() as $entity) {
			$data['users'][] = array(
				'name' => $entity->getRawName(),
				'email' => $entity->getEmail(),
			);
		}

		$data['repositories'] = array();
		foreach ($config->getRepositories() as $repository) {
			$repositoryName = $repository->getName();

			$data['repositories'][$repositoryName] = array();
			$data['repositories'][$repositoryName]['options'] = $this->createOptionList($repository);
			$data['repositories'][$repositoryName]['access'] = $this->createAccessList($repository);
		}

		return json_encode($data);
	}

	private function createOptionList(Repository $repository)
	{
		$result = array();
		foreach ($repository->getOptions() as $name => $value) {
			$result[$name] = $value;
		}
		return $result;
	}

	private function createAccessList(Repository $repository)
	{
		$result = array();
		foreach ($repository->getAccessList() as $name => $access) {
			$result[$name] = '';

			if ($access->isAllowed(Access::READ)) {
				$result[$name] .= 'R';
			}

			if ($access->isAllowed(Access::WRITE)) {
				$result[$name] .= 'W';
			}
		}
		return $result;
	}

	public function load($path)
	{
		$config = new Config();

		if (!is_file($path)) {
			return $config;
		}

		$content = file_get_contents($path);
		$data = @json_decode($content);
		if (!$data || !is_object($data)) {
			return $config;
		}

		if (isset($data->groups) && is_array($data->groups)) {
			foreach ($data->groups as $group) {
				$entity = new Group();
				$entity->setName($group->name);
				$config->addGroup($entity);
			}
		}

		if (isset($data->users) && is_array($data->users)) {
			foreach ($data->users as $user) {
				$entity = new User();
				$entity->setName($user->name);
				$entity->setEmail($user->email);

				$config->addUser($entity);
			}
		}

		if (isset($data->repositories) && is_object($data->repositories)) {
			foreach ($data->repositories as $name => $repository) {
				$entity = new Repository();
				$entity->setName($name);

				foreach ($repository->options as $optionName => $optionValue) {
					$entity->setOption($optionName, $optionValue);
				}

				foreach ($repository->access as $name => $permission) {
					if ($name[0] == '@') {
						$child = $config->getGroup(substr($name, 1));
					} else {
						$child = $config->getUser($name);
					}

					if ($child) {
						$access = new Access($permission);
						$entity->setAccess($child, $access);
					}
				}

				$config->addRepository($entity);
			}
		}

		return $config;
	}

	public function save(Config $config, $path)
	{
		$json = $this->create($config);

		file_put_contents($path, $json);
		return $this;
	}
}
