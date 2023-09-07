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
    $trail->push('Penanda', route('maps.index'));
});

// Maps create
Breadcrumbs::for('maps.create', function (BreadcrumbTrail $trail) {
    $trail->parent('maps.index');
    $trail->push('Tambah Penanda ', route('maps.create'));
});

// Maps edit
// User Edit
Breadcrumbs::for('maps.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('maps.index');
    $trail->push('Penanda Edit', route('maps.edit', $id));
});
