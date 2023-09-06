<?php


use Diglactic\Breadcrumbs\Breadcrumbs;


use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Maps
Breadcrumbs::for('maps.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Maps', route('maps.index'));
});
// Maps create
Breadcrumbs::for('maps.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Maps', route('maps.index'));
    $trail->push('Maps create ', route('maps.create'));
});
