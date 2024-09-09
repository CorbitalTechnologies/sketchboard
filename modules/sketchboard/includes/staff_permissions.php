<?php

/*
 * Inject permissions Feature and Capabilities for sketchboard module
 */
hooks()->add_filter('staff_permissions', function ($permissions) {
    $allPermissionsArray = [
        'view'     => _l('permission_view'),
        'create'   => _l('permission_create'),
    ];
    $permissions['sketchboard'] = [
        'name'         => _l('sketchboard'),
        'capabilities' => $allPermissionsArray,
    ];
    return $permissions;
});
