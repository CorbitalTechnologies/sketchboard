<?php

/*
 * Inject css file for sketchboard module
 */
hooks()->add_action('app_admin_head', function () {
    // Check module is enable or not (refer install.php)
    if (get_instance()->app_modules->is_active('sketchboard')) {
        echo '<link href="' . module_dir_url('sketchboard', 'assets/css/sketchboard.css') . '?v=' . get_instance()->app_scripts->core_version() . '"  rel="stylesheet" type="text/css" />';
    }
});

/*
 * Inject Javascript file for sketchboard module
 */
hooks()->add_action('app_admin_footer', function () {
    if (get_instance()->app_modules->is_active('sketchboard')) {
    }
});
