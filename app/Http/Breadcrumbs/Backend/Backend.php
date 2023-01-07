<?php 
Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin.dashboard'));
});
require __DIR__ . '/User.php';
require __DIR__ . '/Role.php';