<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssueDoctrineORM;

use CollabIssueDoctrineORM\Mapper\IssueMapper;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CollabIssue\Mapper\MapperInterface' => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new IssueMapper($em);
                },
            ),
        );
    }
}
