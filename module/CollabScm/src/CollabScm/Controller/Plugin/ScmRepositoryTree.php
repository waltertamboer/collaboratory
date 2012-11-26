<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Controller\Plugin;

use CollabScm\Entity\Repository;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ScmRepositoryTree extends AbstractPlugin
{
    public function __invoke(Repository $repository)
    {
        $repositoryPath = $this->getRepositoryPath($repository);

        $result = array();
        if ($repository->getType() == 'git') {
            $command = new \CollabScmGit\Api\Command\ListTree();
            $command->setPath('.' . rtrim($this->getController()->scmPath(), '/') . '/');
            $command->setRepository($repositoryPath);

            $result = $command->execute();
        }
        return $result;
    }

    private function getRepositoryPath(Repository $repository)
    {
        $project = $repository->getProject();

        $projectName = preg_replace('/[^a-z0-9-]+/i', '', $project->getName());
        $projectPath = getcwd() . '/data/projects/' . strtolower($projectName) . '/repositories/';

        $repoName = preg_replace('/[^a-z0-9-]+/i', '', $repository->getName());

        return realpath($projectPath . '/' . strtolower($repoName));
    }
}
