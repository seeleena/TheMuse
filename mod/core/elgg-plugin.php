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
                        'path' => 'Core/course/assignment/add',
                        'resource' => 'course/addAssignment',
                ],
                'default:Core:course:newCourseRun' => [
                        'path' => 'Core/course/addRun',
                        'resource' => 'course/newCourseRun',
                ],
                  
    ],
    
];