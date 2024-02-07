<?php

return [
        'entities' => [
                [
                        'type' => 'object',
                        'subtype' => 'my_blog',
                        'capabilities' => [
                                'searchable' => true,
                        ],
                ],
        ],
        'actions' => [
                'my_blog/save' => [],
        ],
        'routes' => [
                'view:object:blog' => [
                        'path' => '/my_blog/view/{guid}/{title?}',
                        'resource' => 'my_blog/view',
                ],
                'add:object:blog' => [
                        'path' => '/my_blog/add/{guid?}',
                        'resource' => 'my_blog/add',
                ],
                'collection:object:my_blog:all' => [
                    'path' => '/my_blog/all',
                    'resource' => 'my_blog/all',
                ],
                'edit:object:blog' => [
                        'path' => '/my_blog/edit/{guid}/{revision?}',
                        'resource' => 'my_blog/edit',
                        'requirements' => [
                                'revision' => '\d+',
                        ],
                ],
        ],
];