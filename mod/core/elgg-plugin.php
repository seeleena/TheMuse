<?php

// Start a new session or resume the existing one
session_start();

// Import the Options class from the Elgg\Muse\Menus for toolbar items
use Elgg\Muse\Menus\Options;

// Return an array with the plugin configuration
return [
    // Plugin details
    'plugin' => [
        'name' => 'Core', // The name of the plugin
    ],
    // The class to use for bootstrapping the plugin
    'bootstrap' => Options::class,
    // Entities that the plugin defines
    'entities' => [
        [
            'type' => 'core', // The type of the entity
            'subtype' => 'core', // The subtype of the entity
            'capabilities' => [
                'commentable' => false, // The entity is not commentable
                'searchable' => true, // The entity is searchable
                'likable' => false, // The entity is not likable
            ],
        ],
    ],
    // Routes that the plugin defines
    'routes' => [
                'default:Core:student:landing' => [
                        'path' => 'Core/student/landing',
                        'resource' => 'students/landing',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],  

                'default:Core:student:assignmentListing' => [
                        'path' => 'Core/assignment/viewAll',
                        'resource' => 'students/assignmentListing',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:uploadZipSolution' => [
                        'path' => 'Core/myCreativeProcess/uploadSolution/{assignID}',
                        'resource' => 'myCreativeProcess/uploadZipSolution',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:survey' => [
                        'path' => 'Core/myCreativeProcess/survey',
                        'resource' => 'myCreativeProcess/survey',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:studentCreatedActivity' => [
                        'path' => 'Core/myCreativeProcess/studentCreatedActivity/{aID}',
                        'resource' => 'myCreativeProcess/studentCreatedActivity',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:home' => [
                        'path' => 'Core/myCreativeProcess/home',
                        'resource' => 'myCreativeProcess/home',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:newUserActivity' => [
                        'path' => 'Core/myCreativeProcess/newUserActivity/{activityID}',
                        'resource' => 'myCreativeProcess/newUserActivity',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:main' => [
                        'path' => 'Core/myCreativeProcess/owner/{assignID?}',
                        'resource' => 'myCreativeProcess/main',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:activity' => [
                        'path' => 'Core/myCreativeProcess/activity/{activityID}',
                        'resource' => 'myCreativeProcess/activity',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:feedbackDashboard' => [
                        'path' => 'Core/myCreativeProcess/feedbackDashboard/{assignmentID}',
                        'resource' => 'myCreativeProcess/feedbackDashboard',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myCreativeProcess:improvementActivities' => [
                        'path' => 'Core/myCreativeProcess/improvementActivities/{CFID}',
                        'resource' => 'myCreativeProcess/improvementActivities',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:instructor:landing' => [
                        'path' => 'Core/instructor/landing',
                        'resource' => 'instructor/landing',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],  
                
                'default:Core:course:new' => [
                        'path' => 'Core/course/add',
                        'resource' => 'course/new',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],

                'default:Core:course:populate' => [
                        'path' => 'Core/course/populate',
                        'resource' => 'course/populate',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],

                'default:Core:course:addAssignment' => [
                        'path' => 'Core/assignment/add',
                        'resource' => 'assignment/addAssignment',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],

                'default:Core:course:newCourseRun' => [
                        'path' => 'Core/course/addRun',
                        'resource' => 'course/newCourseRun',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],

                'default:Core:assignments:grouping' => [
                        'path' => 'Core/assignment/grouping',
                        'resource' => 'assignment/grouping',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:assignments:viewDetails' => [
                        'path' => 'Core/assignment/view/{assignID}',
                        'resource' => 'assignment/viewDetails',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:assignments:getByCourse' => [
                        'path' => 'Core/assignment/get/{code}',
                        'resource' => 'assignment/getByCourse',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:assignments:getQuestionTypeByDomain' => [
                        'path' => 'Core/assignment/getQuestionType/{domain}',
                        'resource' => 'assignment/getQuestionTypeByDomain',
                ],

                'default:Core:myTools:collaborativeInput:main' => [
                        'path' => 'Core/myTools/collaborativeInput/', 
                        'resource' => 'myTools/collaborativeInput',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:myTools:listAndApply:main' => [
                        'path' => 'Core/myTools/listAndApply/', 
                        'resource' => 'myTools/listAndApply',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                
                'default:Core:myTools:roundRobin:main' => [
                        'path' => 'Core/myTools/roundRobin/',
                        'resource' => 'myTools/roundRobin',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                `default:Core:myTools:conceptFan:main` => [
                        'path' => 'Core/myTools/conceptFan/',
                        'resource' => 'myTools/conceptFan',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools:choice:main' => [
                        'path' => 'Core/myTools/choice/',
                        'resource' => 'myTools/choice',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools:list:main' => [
                        'path' => 'Core/myTools/list/',
                        'resource' => 'myTools/list',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools/inAndOut:main' => [
                        'path' => 'Core/myTools/inAndOut/',
                        'resource' => 'myTools/inAndOut',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools/report:main' => [
                        'path' => 'Core/myTools/report/',
                        'resource' => 'myTools/report',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools/randomWordGenerator:main' => [
                        'path' => 'Core/myTools/randomWordGenerator/',
                        'resource' => 'myTools/randomWordGenerator',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools:underConstruction' => [
                        'path' => 'Core/myTools/construction',
                        'resource' => 'myTools/underConstruction',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools:main' => [
                        'path' => 'Core/myTools/main',
                        'resource' => 'myTools/main',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools:stretches:simple' => [
                        'path' => 'Core/myTools/stretches',
                        'resource' => 'myTools/stretches',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],
                'default:Core:myTools:report:main' => [
                        'path' => 'Core/myTools/report/',
                        'resource' => 'myTools/report',
                        'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
                ],

                'default:Core:instructor:creativePedagogy' => [
                        'path' => 'Core/grading/creativePedagogy/{assignID?}',
                        'resource' => 'grading/creativePedagogy',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],

                'default:Core:instructor:grading' => [
                        'path' => 'Core/grading',
                        'resource' => 'grading/main',
                        'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
                ],  
                'default' => [
                        'path' => 'Core/myTools/storeTimeOnPage/',
                        'resource' => 'myTools/storeTimeOnPage',
                ],
        ],

        // Define the actions that the plugin provides
        'actions' => [
                'course/save' => [],
                'course/saveCourseRun' => [],
                'course/populate' => [],
                'course/addAssignment' => [],
                'assessment/saveGrades' => [],
                'assessment/csds' => [],
                'instructor/setCSDScriteria' => [],
                'myCreativeProcess/saveNewUserActivity' => [],
                'myCreativeProcess/saveStudentSurvey' => [],
                'myTools/roundRobin/save'=> [],
                'myTools/collaborativeInput/save'=> [],
                'myTools/conceptFan/save'=> [],
                'myTools/choice/save'=> [],
                'myTools/list/save'=> [],
                'myTools/listAndApply/save'=> [],
                'myTools/inAndOut/save'=> [],
                'myTools/report/save'=> [],
                'myTools/randomWordGenerator/save'=> [],
                'uploadAssignmentSolution'=> [],
                'usersettings/save'=> [],
        ],
];