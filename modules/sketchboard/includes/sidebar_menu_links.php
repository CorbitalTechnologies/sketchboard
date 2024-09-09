<?php

/*
 * Inject sidebar menu and links for sketchboard module
 */
hooks()->add_action('admin_init', 'sketchboard_module_init_menu_items');
function sketchboard_module_init_menu_items()
{
    if (staff_can('view', 'sketchboard')) {
        get_instance()->app_menu->add_sidebar_menu_item('sketchboard', [
            'slug'     => 'sketchboard',
            'name'     => _l('sketchboard'),
            'icon'     => 'fa fa-object-group',
            'href'     => '#',
            'position' => 20,
        ]);
    }

    if (staff_can('view', 'sketchboard')) {
        get_instance()->app_menu->add_sidebar_children_item('sketchboard', [
            'slug'     => 'sketch_board',
            'name'     => _l('sketch_board'),
            'href'     => admin_url('sketchboard'),
            'position' => 1,
        ]);
    }
}
