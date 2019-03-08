<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Permissions
    |--------------------------------------------------------------------------
    */

    'access backend' => [
        'display_name' => 'permissions.access.backend.display_name',
        'description'  => 'permissions.access.backend.description',
        'category'     => 'permissions.categories.access',
    ],

    'view jobcards' => [
        'display_name' => 'permissions.view.jobcards.display_name',
        'description'  => 'permissions.view.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
        'children'     => ['view own jobcards'],
    ],

    'create jobcards' => [
        'display_name' => 'permissions.create.jobcards.display_name',
        'description'  => 'permissions.create.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
    ],

    'edit jobcards' => [
        'display_name' => 'permissions.edit.jobcards.display_name',
        'description'  => 'permissions.edit.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
        'children'     => ['edit own jobcards'],
    ],

    'delete jobcards' => [
        'display_name' => 'permissions.delete.jobcards.display_name',
        'description'  => 'permissions.delete.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
        'children'     => ['delete own jobcards'],
    ],

    'view own jobcards' => [
        'display_name' => 'permissions.view.own.jobcards.display_name',
        'description'  => 'permissions.view.own.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
    ],

    'edit own jobcards' => [
        'display_name' => 'permissions.edit.own.jobcards.display_name',
        'description'  => 'permissions.edit.own.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
    ],

    'delete own jobcards' => [
        'display_name' => 'permissions.delete.own.jobcards.display_name',
        'description'  => 'permissions.delete.own.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
    ],

    'publish jobcards' => [
        'display_name' => 'permissions.publish.jobcards.display_name',
        'description'  => 'permissions.publish.jobcards.description',
        'category'     => 'permissions.categories.jobcards',
    ],

    'view form_settings' => [
        'display_name' => 'permissions.view.form_settings.display_name',
        'description'  => 'permissions.view.form_settings.description',
        'category'     => 'permissions.categories.form',
    ],

    'create form_settings' => [
        'display_name' => 'permissions.create.form_settings.display_name',
        'description'  => 'permissions.create.form_settings.description',
        'category'     => 'permissions.categories.form',
    ],

    'edit form_settings' => [
        'display_name' => 'permissions.edit.form_settings.display_name',
        'description'  => 'permissions.edit.form_settings.description',
        'category'     => 'permissions.categories.form',
    ],

    'delete form_settings' => [
        'display_name' => 'permissions.delete.form_settings.display_name',
        'description'  => 'permissions.delete.form_settings.description',
        'category'     => 'permissions.categories.form',
    ],

    'view form_submissions' => [
        'display_name' => 'permissions.view.form_submissions.display_name',
        'description'  => 'permissions.view.form_submissions.description',
        'category'     => 'permissions.categories.form',
    ],

    'delete form_submissions' => [
        'display_name' => 'permissions.delete.form_submissions.display_name',
        'description'  => 'permissions.delete.form_submissions.description',
        'category'     => 'permissions.categories.form',
    ],

    'view users' => [
        'display_name' => 'permissions.view.users.display_name',
        'description'  => 'permissions.view.users.description',
        'category'     => 'permissions.categories.access',
    ],

    'create users' => [
        'display_name' => 'permissions.create.users.display_name',
        'description'  => 'permissions.create.users.description',
        'category'     => 'permissions.categories.access',
    ],

    'edit users' => [
        'display_name' => 'permissions.edit.users.display_name',
        'description'  => 'permissions.edit.users.description',
        'category'     => 'permissions.categories.access',
    ],

    'delete users' => [
        'display_name' => 'permissions.delete.users.display_name',
        'description'  => 'permissions.delete.users.description',
        'category'     => 'permissions.categories.access',
    ],

    'impersonate users' => [
        'display_name' => 'permissions.impersonate.display_name',
        'description'  => 'permissions.impersonate.description',
        'category'     => 'permissions.categories.access',
    ],

    'view roles' => [
        'display_name' => 'permissions.view.roles.display_name',
        'description'  => 'permissions.view.roles.description',
        'category'     => 'permissions.categories.access',
    ],

    'create roles' => [
        'display_name' => 'permissions.create.roles.display_name',
        'description'  => 'permissions.create.roles.description',
        'category'     => 'permissions.categories.access',
    ],

    'edit roles' => [
        'display_name' => 'permissions.edit.roles.display_name',
        'description'  => 'permissions.edit.roles.description',
        'category'     => 'permissions.categories.access',
    ],

    'delete roles' => [
        'display_name' => 'permissions.delete.roles.display_name',
        'description'  => 'permissions.delete.roles.description',
        'category'     => 'permissions.categories.access',
    ],

    'view metas' => [
        'display_name' => 'permissions.view.metas.display_name',
        'description'  => 'permissions.view.metas.description',
        'category'     => 'permissions.categories.seo',
    ],

    'create metas' => [
        'display_name' => 'permissions.create.metas.display_name',
        'description'  => 'permissions.create.metas.description',
        'category'     => 'permissions.categories.seo',
    ],

    'edit metas' => [
        'display_name' => 'permissions.edit.metas.display_name',
        'description'  => 'permissions.edit.metas.description',
        'category'     => 'permissions.categories.seo',
    ],

    'delete metas' => [
        'display_name' => 'permissions.delete.metas.display_name',
        'description'  => 'permissions.delete.metas.description',
        'category'     => 'permissions.categories.seo',
    ],

    'view redirections' => [
        'display_name' => 'permissions.view.redirections.display_name',
        'description'  => 'permissions.view.redirections.description',
        'category'     => 'permissions.categories.seo',
    ],

    'create redirections' => [
        'display_name' => 'permissions.create.redirections.display_name',
        'description'  => 'permissions.create.redirections.description',
        'category'     => 'permissions.categories.seo',
    ],

    'edit redirections' => [
        'display_name' => 'permissions.edit.redirections.display_name',
        'description'  => 'permissions.edit.redirections.description',
        'category'     => 'permissions.categories.seo',
    ],

    'delete redirections' => [
        'display_name' => 'permissions.delete.redirections.display_name',
        'description'  => 'permissions.delete.redirections.description',
        'category'     => 'permissions.categories.seo',
    ],
];
