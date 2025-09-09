<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [

        // أعلى صلاحيات - وصول كامل
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'grades' => 'c,r,u,d',
            'sections' => 'c,r,u,d',
            'subjects' => 'c,r,u,d',
            'students' => 'c,r,u,d',
            'teachers' => 'c,r,u,d',
            'guardians' => 'c,r,u,d',
            'attendance' => 'c,r,u,d',
            'exams' => 'c,r,u,d',
            'marks' => 'c,r,u,d',
            'profile' => 'r,u',
        ],

        // مدير المدرسة
        'administrator' => [
            'students' => 'c,r,u,d',
            'teachers' => 'c,r,u,d',
            'guardians' => 'c,r,u,d',
            'grades' => 'c,r,u,d',
            'sections' => 'c,r,u,d',
            'subjects' => 'c,r,u,d',
            'attendance' => 'c,r,u,d',
            'exams' => 'c,r,u,d',
            'marks' => 'c,r,u,d',
            'profile' => 'r,u',
        ],

        // المعلم
        'teacher' => [
            'students' => 'r',
            'attendance' => 'c,r,u',
            'marks' => 'c,r,u',
            'exams' => 'r',
            'subjects' => 'r',
            'profile' => 'r,u',
        ],

        // الطالب
        'student' => [
            'marks' => 'r',
            'attendance' => 'r',
            'exams' => 'r',
            'profile' => 'r,u',
        ],

        // ولي الأمر
        'guardian' => [
            'students' => 'r',
            'marks' => 'r',
            'attendance' => 'r',
            'profile' => 'r,u',
        ],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
