<?php

namespace Maps;

use Laminas\Mvc\Controller\LazyControllerAbstractFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Maps\Controller\IndexController;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Maps\Form\LokalizacjaForm;
use Maps\Model\Lokalizacje;

return [
    'router' => [
        'routes' => [
            'maps' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/maps',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'pobierz',
                    ],
                ],
            ],
            'dodawanie' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/maps/dodaj',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'dodaj',
                    ],
                ],
            ],

        ],
    ],
    'service_manager' => [
        'factories' => [
            Lokalizacje::class => ReflectionBasedAbstractFactory::class,
            LokalizacjaForm::class => ReflectionBasedAbstractFactory::class,
        ],

    ],
    'controllers' => [
        'factories' => [
            IndexController::class => LazyControllerAbstractFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
