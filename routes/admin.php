<?php

Route::get('index/search', 'AjaxController@search')->name('search');
Route::get('routes/search', 'AjaxController@routesSearch')->name('routes.search');
Route::get('tags/search', 'AjaxController@tagsSearch')->name('tags.search');
Route::post('images/upload', 'AjaxController@imageUpload')->name('images.upload');
Route::get('labours/getrates', 'AjaxController@getLabourRates')->name('labours.getids');
Route::get('materials/getrates', 'AjaxController@getMaterialRates')->name('materials.getids');
Route::get('vats/getrates', 'AjaxController@getVatRates')->name('vats.getids');

Route::get('district/getids','AjaxController@getDistricts')->name('district.getdata');
Route::get('subdistrict/getids','AjaxController@getSubDistricts')->name('subdistrict.getdata');

Route::get('projects/getids', 'AjaxController@getProjects')->name('projects.getdata');
Route::get('project_manager/getids', 'AjaxController@getProjectManager')->name('project_manager.getdata');
Route::get('labours/info', 'AjaxController@getLabours')->name('labours.getdata');
Route::get('labours/search', 'AjaxController@searchLabours')->name('labours.searchlabour');
Route::get('materials/info', 'AjaxController@getMaterials')->name('materials.getdata');
Route::get('users/getids', 'AjaxController@getUsers')->name('users.getdata');
Route::get('quotations/getids', 'AjaxController@getQuotations')->name('quotations.getdata');
Route::get('jobcards/getids', 'AjaxController@getJobcards')->name('jobcards.getdata');
Route::get('vats/getids', 'AjaxController@getVats')->name('vats.getdata');
Route::get('project_managers/getids', 'AjaxController@getProjectManagers')->name('project_managers.getdata');
Route::get('settings/data', 'AjaxController@getSettingsData')->name('settings.getdata');
Route::get('quotations/lastref', 'AjaxController@getQuotationsRecentReference')->name('quotations.getreference');
Route::get('clients/search', 'AjaxController@searchClients')->name('clients.searchclients');
Route::get('quotations/search', 'AjaxController@searchQuotes')->name('quotations.searchquotes');
Route::post('jobcards/removeimage', 'AjaxController@JobcardRemoveImage')->name('jobcards.removeimage');
Route::get('invoices/lastref', 'AjaxController@getInvoicesRecentReference')->name('invoices.getreference');

/* JobCard Routes */
Route::post('jobcards/batch_action', 'JobcardController@batchAction')->name('jobcards.batch_action');
Route::get('jobcards/{jobcard}/show', 'JobcardController@show')->name('jobcards.show');
Route::get('jobcards/search', 'JobcardController@search')->name('jobcards.search');
Route::get('jobcards/latest', 'JobcardController@getLastestJobcards')->name('jobcards.latest');
Route::resource('jobcards', 'JobcardController', ['only' => ['store', 'update', 'destroy'],]);
Route::post('jobscards/addedfile', 'JobcardController@addedfile')->name('jobcards.addedfile');
//Route::post('jobscards/file', 'JobcardController@file')->name('jobcards.file');
Route::post('jobscards/store', 'JobcardController@store')->name('jobcards.store');


/* Project Routes */
Route::post('projects/batch_action', 'ProjectController@batchAction')->name('projects.batch_action');
Route::get('projects/{project}/show', 'ProjectController@show')->name('projects.show');
Route::get('projects/search', 'ProjectController@search')->name('projects.search');
Route::get('projects/latest', 'ProjectController@getLastestprojects')->name('projects.latest');
Route::resource('projects', 'ProjectController', ['only' => ['store', 'update', 'destroy'],]);

/* Project Manager Routes */
Route::post('project_managers/batch_action', 'ProjectManagerController@batchAction')->name('project_managers.batch_action');
Route::get('project_managers/{project_manager}/show', 'ProjectManagerController@show')->name('project_managers.show');
Route::get('project_managers/search', 'ProjectManagerController@search')->name('project_managers.search');
Route::resource('project_managers', 'ProjectManagerController', ['only' => ['store', 'update', 'destroy'],]);


/* Labour Rates Routes */
Route::post('labour_rates/batch_action', 'LabourRateController@batchAction')->name('labour_rates.batch_action');
Route::get('labour_rates/{labour_rate}/show', 'LabourRateController@show')->name('labour_rates.show');
Route::get('labour_rates/search', 'LabourRateController@search')->name('labour_rates.search');
Route::resource('labour_rates', 'LabourRateController', ['only' => ['store', 'update', 'destroy'],]);

/* Material Rates Routes */
Route::post('materials_rates/batch_action', 'MaterialRateController@batchAction')->name('materials_rates.batch_action');
Route::get('materials_rates/{materials_rate}/show', 'MaterialRateController@show')->name('materials_rates.show');
Route::get('materials_rates/search', 'MaterialRateController@search')->name('materials_rates.search');
Route::resource('materials_rates', 'MaterialRateController', ['only' => ['store', 'update', 'destroy'],]);

/* Vat Routes */
Route::post('vat/batch_action', 'VatController@batchAction')->name('vat.batch_action');
Route::get('vat/{vat}/show', 'VatController@show')->name('vat.show');
Route::get('vat/search', 'VatController@search')->name('vat.search');
Route::resource('vat', 'VatController', ['only' => ['store', 'update', 'destroy'],]);

/* Reports Routes */
Route::post('reports/batch_action', 'ReportsController@batchAction')->name('reports.batch_action');
Route::get('reports/{report}/show', 'ReportsController@show')->name('reports.show');
Route::get('reports/search', 'ReportsController@search')->name('reports.search');
Route::resource('reports', 'ReportsController', ['only' => ['store', 'update', 'destroy'],]);

/* Settings Routes */
Route::post('settings/batch_action', 'SettingsController@batchAction')->name('settings.batch_action');
Route::get('settings/{setting}/show', 'SettingsController@show')->name('settings.show');
Route::get('settings/search', 'SettingsController@search')->name('settings.search');
Route::resource('settings', 'SettingsController', ['only' => ['store', 'update', 'destroy'],]);



/* Districts Routes */
Route::post('districts/batch_action', 'DistrictController@batchAction')->name('districts.batch_action');
Route::get('districts/{district}/show', 'DistrictController@show')->name('districts.show');
Route::get('districts/search', 'DistrictController@search')->name('districts.search');
Route::resource('districts', 'DistrictController', ['only' => ['store', 'update', 'destroy'],]);




/* SubDistricts Routes */
Route::post('subdistricts/batch_action', 'SubDistrictController@batchAction')->name('subdistricts.batch_action');
Route::get('subdistricts/{subdistrict}/show', 'SubDistrictController@show')->name('subdistricts.show');
Route::get('subdistricts/search', 'SubDistrictController@search')->name('subdistricts.search');
Route::resource('subdistricts', 'SubDistrictController', ['only' => ['store', 'update', 'destroy'],]);



/* Invoices Routes */
Route::post('invoices/batch_action', 'InvoicesController@batchAction')->name('invoices.batch_action');
Route::get('invoices/{invoice}/show', 'InvoicesController@show')->name('invoices.show');
Route::get('invoices/search', 'InvoicesController@search')->name('invoices.search');
Route::resource('invoices', 'InvoicesController', ['only' => ['store', 'update', 'destroy'],]);

/* Quotes Routes */
Route::post('quotes/batch_action', 'QuotesController@batchAction')->name('quotes.batch_action');
Route::get('quotes/{quote}/show', 'QuotesController@show')->name('quotes.show');
Route::get('quotes/search', 'QuotesController@search')->name('quotes.search');
Route::get('quotes/latest', 'QuotesController@getLastestquotes')->name('quotes.latest');
// Route::get('quotes/index', 'QuotesController@index')->name('quotes.index');
Route::resource('quotes', 'QuotesController', [
                'only' => ['store', 'update', 'destroy'],
            ]);
Route::group(
    ['middleware' => ['can:view form_settings']],
    function () {
        Route::get('form_settings/form_types', 'FormSettingController@getFormTypes')->name('form_settings.get_form_types');

        Route::get('form_settings/search', 'FormSettingController@search')->name('form_settings.search');
        Route::get('form_settings/{form_setting}/show', 'FormSettingController@show')->name('form_settings.show');

        Route::resource('form_settings', 'FormSettingController', [
            'only' => ['store', 'update', 'destroy'],
        ]);
    }
);

Route::group(
    ['middleware' => ['can:view form_submissions']],
    function () {
        Route::get('form_submissions/counter', 'FormSubmissionController@getFormSubmissionCounter')->name('form_submissions.counter');

        Route::get('form_submissions/search', 'FormSubmissionController@search')->name('form_submissions.search');
        Route::get('form_submissions/{form_submission}/show', 'FormSubmissionController@show')->name('form_submissions.show');

        Route::resource('form_submissions', 'FormSubmissionController', [
            'only' => ['destroy'],
        ]);

        Route::post('form_submissions/batch_action', 'FormSubmissionController@batchAction')->name('form_submissions.batch_action');
    }
);

Route::group(
    ['middleware' => ['can:view users']],
    function () {
        Route::get('users/active_counter', 'UserController@getActiveUserCounter')->name('users.active.counter');

        Route::get('users/roles', 'UserController@getRoles')->name('users.get_roles');

        Route::get('users/search', 'UserController@search')->name('users.search');
        Route::get('users/{user}/show', 'UserController@show')->name('users.show');

        Route::resource('users', 'UserController', [
            'only' => ['store', 'update', 'destroy'],
        ]);

        Route::post('users/batch_action', 'UserController@batchAction')->name('users.batch_action');
        Route::post('users/{user}/active', 'UserController@activeToggle')->name('users.active');

        Route::get('users/{user}/impersonate', 'UserController@impersonate')->name('users.impersonate');
    }
);

Route::group(
    ['middleware' => ['can:view roles']],
    function () {
        Route::get('roles/permissions', 'RoleController@getPermissions')->name('roles.get_permissions');

        Route::get('roles/search', 'RoleController@search')->name('roles.search');
        Route::get('roles/{role}/show', 'RoleController@show')->name('roles.show');

        Route::resource('roles', 'RoleController', [
            'only' => ['store', 'update', 'destroy'],
        ]);
    }
);

Route::group(
    ['middleware' => ['can:view metas']],
    function () {
        Route::get('metas/search', 'MetaController@search')->name('metas.search');
        Route::get('metas/{meta}/show', 'MetaController@show')->name('metas.show');

        Route::resource('metas', 'MetaController', [
            'only' => ['store', 'update', 'destroy'],
        ]);

        Route::post('metas/batch_action', 'MetaController@batchAction')->name('metas.batch_action');
    }
);

Route::group(
    ['middleware' => ['can:view redirections']],
    function () {
        Route::get('redirections/redirection_types', 'RedirectionController@getRedirectionTypes')->name('redirections.get_redirection_types');

        Route::get('redirections/search', 'RedirectionController@search')->name('redirections.search');
        Route::get('redirections/{redirection}/show', 'RedirectionController@show')->name('redirections.show');

        Route::resource('redirections', 'RedirectionController', [
            'only' => ['store', 'update', 'destroy'],
        ]);

        Route::post('redirections/batch_action', 'RedirectionController@batchAction')->name('redirections.batch_action');
        Route::post('redirections/{redirection}/active', 'RedirectionController@activeToggle')->name('redirections.active');

        Route::post('redirections/import', 'RedirectionController@import')->name('redirections.import');
    }
);

// if (config('blog.enabled')) {
//     Route::group(
//         ['middleware' => ['can:view own posts']],
//         function () {
//             Route::get('posts/draft_counter', 'PostController@getDraftPostCounter')->name('posts.draft.counter');
//             Route::get('posts/pending_counter', 'PostController@getPendingPostCounter')->name('posts.pending.counter');
//             Route::get('posts/published_counter', 'PostController@getPublishedPostCounter')->name('posts.published.counter');
//             Route::get('posts/latest', 'PostController@getLastestPosts')->name('posts.latest');

//             Route::get('posts/search', 'PostController@search')->name('posts.search');
//             Route::get('posts/{post}/show', 'PostController@show')->name('posts.show');

//             Route::resource('posts', 'PostController', [
//                 'only' => ['store', 'update', 'destroy'],
//             ]);

//             Route::post('posts/batch_action', 'PostController@batchAction')->name('posts.batch_action');
//             Route::post('posts/{post}/pinned', 'PostController@pinToggle')->name('posts.pinned');
//             Route::post('posts/{post}/promoted', 'PostController@promoteToggle')->name('posts.promoted');
//         }
//     );
// }

Route::get('/{vue_capture?}', 'BackendController@index')
    ->where('vue_capture', '[\/\w\.-]*')
    ->name('home');
