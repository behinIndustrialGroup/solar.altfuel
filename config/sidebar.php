<?php

return [
    'menu' =>[

        'dashboard' => [
            'icon' => 'dashboard',
<<<<<<< HEAD
            'fa_name' => 'صفحه نخست',
            'route-url' => 'admin',
=======
            'fa_name' => 'داشبرد',
>>>>>>> parent of f57367e8 (Merge branch 'main' of https://github.com/behinIndustrialGroup/solar.altfuel)
            'submenu' => [
                'dashboard' => [ 'fa_name' => 'داشبرد', 'route-name' => '', 'route-url' => 'admin' ],
            ]
        ],
        'workflow-inbox' => [
            'icon' => 'inbox',
<<<<<<< HEAD
            'fa_name' => 'درخواست های تکمیل نشده',
            'route-name' => 'simpleWorkflow.inbox.index',
=======
            'fa_name' => 'کارتابل',
>>>>>>> parent of f57367e8 (Merge branch 'main' of https://github.com/behinIndustrialGroup/solar.altfuel)
            'submenu' => [
                'new-process' => [ 'fa_name' => 'فرایند جدید', 'route-name' => 'simpleWorkflow.process.startListView' ],
                'inbox' => [ 'fa_name' => 'کارتابل', 'route-name' => 'simpleWorkflow.inbox.index' ],
                'done-inbox' => [ 'fa_name' => 'انجام شده ها', 'route-name' => 'simpleWorkflow.inbox.done' ],
            ]
        ],
        'workflow-report' => [
            'icon' => 'report',
            'fa_name' => 'گزارشات کارتابل',
            'submenu' => [
                'list' => [ 'fa_name' => 'لیست', 'route-name' => 'simpleWorkflowReport.index' ],
                'summary' => [ 'fa_name' => 'خلاصه', 'route-name' => 'simpleWorkflowReport.summary-report.index' ],
                'my-request' => [ 'fa_name' => 'درخواست‌های من', 'route-name' => 'simpleWorkflowReport.my-request.index' ],
                'role-form-control' => [ 'fa_name' => 'فرم گزارش نقش ها', 'route-name' => 'simpleWorkflowReport.role.index' ],
            ]
        ],
        'workflow' => [
            'icon' => 'account_tree',
            'fa_name' => 'گردش کار',
            'submenu' => [
                'process' => [ 'fa_name' => 'فرایند', 'route-name' => 'simpleWorkflow.process.index' ],
                'task-actors' => [ 'fa_name' => 'تسک ها', 'route-name' => 'simpleWorkflow.task-actors.index' ],
                'forms' => [ 'fa_name' => 'فرم ها', 'route-name' => 'simpleWorkflow.form.index'  ],
                'scripts' => [ 'fa_name' => 'اسکریپت ها', 'route-name' => 'simpleWorkflow.scripts.index' ],
                'conditions' => [ 'fa_name' => 'شرط ها', 'route-name' => 'simpleWorkflow.conditions.index' ],
                'fields' => [ 'fa_name' => 'فیلدها', 'route-name' => 'simpleWorkflow.fields.index' ],
                'entities' => [ 'fa_name' => 'موجودیت ها', 'route-name' => 'simpleWorkflow.entities.index' ],
                'all-inbox' => [ 'fa_name' => 'کارتابل همه', 'route-name' => 'simpleWorkflow.inbox.cases.list' ],
            ]
        ],
        'translations' => [
            'icon' => 'language',
            'fa_name' => 'ترجمه',
            'submenu' => [
                'index' => [ 'fa_name' => 'ترجمه', 'route-name' => '', 'route-url' => '/translations' ],
            ]
        ],
        'users' => [
            'icon' => 'person',
            'fa_name' => 'کاربران',
            'submenu' => [
                'dashboard' => [ 'fa_name' => 'همه', 'route-name' => '', 'route-url' => 'user/all' ],
                'role' => [ 'fa_name' => 'نقش ها', 'route-name' => 'role.listForm', 'route-url' => '' ],
                'method' => [ 'fa_name' => 'متد ها', 'route-name' => 'method.list', 'route-url' => '' ],
                'department' => [ 'fa_name' => 'دپارتمان ها', 'route-name' => 'department.index', 'route-url' => '' ],
            ]
        ],
        // 'tickets' => [
        //     'icon' => 'fa fa-ticket',
        //     'fa_name' => 'تیکت پشتیبانی',
        //     'submenu' => [
        //         'create' => [ 'fa_name' => 'ایجاد', 'route-name' => 'ATRoutes.index', 'route-url' => '' ],
        //         'show' => [ 'fa_name' => 'مشاهده', 'route-name' => 'ATRoutes.show.listForm', 'route-url' => '' ],
        //     ]
        // ],

    ]
];
