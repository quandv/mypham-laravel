<?php
Breadcrumbs::register('admin.user.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Manager', route('admin.user.index'));
});

Breadcrumbs::register('admin.user.deleted', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Delete', route('admin.user.deleted'));
});

Breadcrumbs::register('admin.user.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Index', route('admin.user.create'));
});

Breadcrumbs::register('admin.user.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Edit', route('admin.user.edit', $id));
});

