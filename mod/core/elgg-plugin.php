<?php

session_start();

use Elgg\Muse\Menus\Options;

return [
        'plugin' => [
		'name' => 'Core',
	],
        'bootstrap' => Options::class,
        'routes' => [
                'default:Core:student:landing' => [
                        'path' => 'Core/student/landing',
                        'resource' => 'students/landing',
                ],  

                'default:Core:myCreativeProcess:uploadZipSolution' => [
                        'path' => 'Core/myCreativeProcess/uploadZipSolution/{assignID}',
                        'resource' => 'myCreativeProcess/uploadZipSolution',
                ],

                'default:Core:myCreativeProcess:survey' => [
                        'path' => 'Core/myCreativeProcess/survey',
                        'resource' => 'myCreativeProcess/survey',
                ],

                'default:Core:myCreativeProcess:studentCreatedActivity' => [
                        'path' => 'Core/myCreativeProcess/studentCreatedActivity/{aID}',
                        'resource' => 'myCreativeProcess/studentCreatedActivity',
                ],

                'default:Core:myCreativeProcess:home' => [
                        'path' => 'Core/myCreativeProcess/home',
                        'resource' => 'myCreativeProcess/home',
                ],

                'default:Core:myCreativeProcess:newUserActivity' => [
                        'path' => 'Core/myCreativeProcess/newUserActivity/{activityID}',
                        'resource' => 'myCreativeProcess/newUserActivity',
                ],

                'default:Core:myCreativeProcess:main' => [
                        'path' => 'Core/myCreativeProcess/owner/{assignID}',
                        'resource' => 'myCreativeProcess/main',
                ],

                'default:Core:myCreativeProcess:activity' => [
                        'path' => 'Core/myCreativeProcess/activity/{activityID}',
                        'resource' => 'myCreativeProcess/activity',
                ],

                'default:Core:myCreativeProcess:feedbackDashboard' => [
                        'path' => 'Core/myCreativeProcess/feedbackDashboard',
                        'resource' => 'myCreativeProcess/feedbackDashboard',
                ],

                'default:Core:myCreativeProcess:improvementActivities' => [
                        'path' => 'Core/myCreativeProcess/improvementActivities/{myProcessParam}',
                        'resource' => 'myCreativeProcess/improvementActivities',
                ],

                'default:Core:instructor:landing' => [
                        'path' => 'Core/instructor/landing',
                        'resource' => 'instructor/landing',
                ],  
                
                'default:Core:course:new' => [
                        'path' => 'Core/course/add',
                        'resource' => 'course/new',
                ],

                'default:Core:course:populate' => [
                        'path' => 'Core/course/populate',
                        'resource' => 'course/populate',
                ],

                'default:Core:course:addAssignment' => [
                        'path' => 'Core/assignment/add',
                        'resource' => 'assignment/addAssignment',
                ],

                'default:Core:course:newCourseRun' => [
                        'path' => 'Core/course/addRun',
                        'resource' => 'course/newCourseRun',
                ],

                'default:Core:assignments:grouping' => [
                        'path' => 'Core/assignment/grouping',
                        'resource' => 'assignment/grouping',
                ],

                'default:Core:assignments:viewDetails' => [
                        'path' => 'Core/assignment/view/{assignID}',
                        'resource' => 'assignment/viewDetails',
                ],

                'default:Core:assignments:getByCourse' => [
                        'path' => 'Core/assignment/get/{courseCode}',
                        'resource' => 'assignment/getByCourse',
                ],

                'default:Core:myTools:collaborativeInput:main' => [
                        'path' => 'Core/myTools/collaborativeInput/{instructionID}/{assignmentID}/{activityID}', 
                        'resource' => 'myTools/collaborativeInput',
                ],

                'default:Core:myTools:listAndApply:main' => [
                        'path' => 'Core/myTools/listAndApply/{instructionID}/{assignmentID}/{activityID}', 
                        'resource' => 'myTools/listAndApply',
                ],
                
                'default:Core:myTools:roundRobin:main' => [
                        'path' => 'Core/myTools/roundRobin/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/roundRobin',
                ],
                `default:Core:myTools:conceptFan:main` => [
                        'path' => 'Core/myTools/conceptFan/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/conceptFan',
                ],
                'default:Core:myTools:choice:main' => [
                        'path' => 'Core/myTools/choice/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/choice',
                ],
                'default:Core:myTools:list:main' => [
                        'path' => 'Core/myTools/list/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/list',
                ],
                'default:Core:myTools/inAndOut:main' => [
                        'path' => 'Core/myTools/inAndOut/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/inAndOut',
                ],
                'default:Core:myTools/report:main' => [
                        'path' => 'Core/myTools/report/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/report',
                ],
                'default:Core:myTools/randomWordGenerator:main' => [
                        'path' => 'Core/myTools/randomWordGenerator/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/randomWordGenerator',
                ],
                'default:Core:myTools:underConstruction' => [
                        'path' => 'Core/myTools/construction',
                        'resource' => 'myTools/underConstruction',
                ],
                'default:Core:myTools:main' => [
                        'path' => 'Core/myTools/main',
                        'resource' => 'myTools/main',
                ],
                'default:Core:myTools:stretches:simple' => [
                        'path' => 'Core/myTools/stretches',
                        'resource' => 'myTools/stretches',
                ],
                'default:Core:myTools:report:main' => [
                        'path' => 'Core/myTools/report/{instructionID}/{assignmentID}/{activityID}',
                        'resource' => 'myTools/report',
                ],

                
        ],
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
        'event' => [
                'register' => [
			'menu:site' => [
				'Elgg\Muse\Menus\Site::register' => [],
			],
                ],
                
        ],
        
    
];