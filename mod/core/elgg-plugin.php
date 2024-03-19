<?php

return [
        'routes' => [
                'default:Core:instructor:landing' => [
                        'path' => 'Core/instructor/landing',
                        'resource' => 'instructorLanding',
                ],  
                'default:Core:student:landing' => [
                        'path' => 'Core/student/landing',
                        'resource' => 'studentLanding',
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
                        'resource' => 'course/addAssignment',
                ],
                'default:Core:course:newCourseRun' => [
                        'path' => 'Core/course/addRun',
                        'resource' => 'course/newCourseRun',
                ],
                'default:Core:assignments:getByCourse' => [
                        'path' => 'Core/assignments/getByCourse',
                        'resource' => 'assignment/getByCourse',
                ],
                'default:Core:myCreativeProess:uploadZipSolution' => [
                        'path' => 'Core/myCreativeProcess/uploadZipSolution',
                        'resource' => 'uploadZipSolution',
                ],
                'default:Core:myCreativeProcess:feedbackDashboard' => [
                        'path' => 'Core/myCreativeProcess/feedbackDashboard',
                        'resource' => 'feedbackDashboard',
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
                'myTools/randomWordGenerator/sav'=> [],
                'uploadSolution/saveZipSolution'=> [],
                'usersettings/save'=> [],
        ],
    
];
