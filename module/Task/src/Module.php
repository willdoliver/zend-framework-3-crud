<?php

namespace Task;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\ModuleManager\Feature\configProviderInterface;


class Module implements configProviderInterface
{
    const VERSION = '3.1.4dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(){
        return [
            'factories' => [
                Model\TaskTable::class => function($container){
                    $tableGateway = $container->get(Model\TaskTableGateway::class);
                    return new Model\TaskTable($tableGateway);
                },
                Model\TaskTableGateway::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Task);
                    return new tableGateway('tasks', $adapter, null, $resultSetPrototype);
                }
            ]
        ];
    }

    public function getControllerConfig(){
        return[
            'factories' => [
                Controller\IndexController::class => function($container){
                    return new Controller\IndexController($container->get(Model\TaskTable::class));
                }
            ]
        ];
    }
}
