<?php

// Home
Breadcrumb::define('home', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
});

// Device list
Breadcrumb::define('devices', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
    $breadcrumb->add(__('label.breadcrumbs.devices'), action('DeviceController@index'));
});
// Device import
Breadcrumb::define('devices.import', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
    $breadcrumb->add(__('label.breadcrumbs.devices'), action('DeviceController@index'));
    $breadcrumb->add(__('label.breadcrumbs.devices_import'), action('DeviceController@importList'));
});
// Project list
Breadcrumb::define('projects', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
    $breadcrumb->add(__('label.breadcrumbs.projects'), action('ProjectController@index'));
});
// Request list
Breadcrumb::define('requests', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
    $breadcrumb->add(__('label.breadcrumbs.requests'), action('RequestController@index'));
});
// Report list
Breadcrumb::define('reports', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
    $breadcrumb->add(__('label.breadcrumbs.reports'), action('ReportController@index'));
});
// Profile page
Breadcrumb::define('profile', function ($breadcrumb, $user) {
    $breadcrumb->add(__('label.breadcrumbs.home'), action('HomeController@index'));
    $breadcrumb->add(__('label.breadcrumbs.profile'), route('users.profile', $user->id));
});
Breadcrumb::define('configs', function ($breadcrumb) {
    $breadcrumb->add(__('label.breadcrumbs.configs'), action('ConfigController@index'));
});