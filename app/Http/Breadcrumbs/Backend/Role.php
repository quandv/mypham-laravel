<?php
Breadcrumbs::register('admin.role.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Manager', route('admin.user.index'));
});

Breadcrumbs::register('admin.role.deleted', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Delete', route('admin.user.deleted'));
});

Breadcrumbs::register('admin.role.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Index', route('admin.user.create'));
});

Breadcrumbs::register('admin.role.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Edit', route('admin.user.edit', $id));
});
