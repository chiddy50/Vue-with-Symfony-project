<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.bY1MqeR' shared service.

return $this->privates['.service_locator.bY1MqeR'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'postRepository' => ['privates', 'App\\Repository\\PostRepository', 'getPostRepositoryService.php', true],
]);
