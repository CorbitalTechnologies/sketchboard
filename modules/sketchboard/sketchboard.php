<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
    Module Name: Sketchboard
    Description: Create Stunning Visuals, Diagrams, and Wireframes Easily, perfect for any purpose you have in mind.
    Version: 1.0.0
    Requires at least: 3.0.*
    Author: <a href="https://codecanyon.net/user/corbitaltech" target="_blank">Corbital Technologies<a/>
*/

/*
 * Define module name
 * Module Name Must be in CAPITAL LETTERS
*/
define('SKETCHBOARD_MODULE', 'sketchboard');

/*
 * Register activation module hook
 */
register_activation_hook(SKETCHBOARD_MODULE, function () {
    require_once __DIR__ . '/install.php';
});

/*
 * Register deactivation module hook
 */
register_deactivation_hook(SKETCHBOARD_MODULE, function () {
    update_option('sketchboard_enabled', 0);
});
/*
 * Register language files, must be registered if the module is using languages
 */
register_language_files(SKETCHBOARD_MODULE, [SKETCHBOARD_MODULE]);

register_merge_fields(SKETCHBOARD_MODULE . '/merge_fields/sketchboard_merge_fields');
/*
 * Load module helper file
 */
get_instance()->load->helper(SKETCHBOARD_MODULE . '/sketchboard');

require_once __DIR__ . '/includes/assets.php';
require_once __DIR__ . '/includes/staff_permissions.php';
require_once __DIR__ . '/includes/sidebar_menu_links.php';

/*
 * Inject email template for sketchboard module
 */
hooks()->add_action('after_email_templates', function () {
    $data['hasPermissionEdit'] = staff_can('edit', 'email_templates');
    $data['sketchboard'] = get_instance()->emails_model->get([
        'type'     => 'sketchboard',
        'language' => 'english',
    ]);
    get_instance()->load->view('sketchboard/mail_lists/email_templates_list', $data, false);
});

// add merge field in safty forms email templates
hooks()->add_filter('available_merge_fields', function ($available) {
    foreach ($available as $key => &$val) {
        if (isset($val['staff'])) {
            foreach ($val['staff'] as $k => &$v) {
                $v['available'][] = 'sketchboard';
            }
        }
        if (isset($val['other'])) {
            foreach ($val['other'] as $k => &$v) {
                $v['available'][] = 'sketchboard';
            }
        }
    }

    return $available;
}, 0, 1);

// mail template for share sketchboard with staff
create_email_template(
    'Shared Sketchboard with you',
    "<p>Dear {staff_firstname} {staff_lastname},</p>

    <p>We are pleased to inform you that a new sketchboard titled <strong>'{sketchboard_title}'</strong> has been shared with you.</p>

    <p><strong>Description:</strong><br>
    {sketchboard_description}</p>

    <p><strong>Created By:</strong><br>
    {sketchboard_created_by}</p>

    <p>You can access the sketchboard using the following link:<br>
    <a href='{sketchboard_url}' target='_blank'>View Sketchboard</a></p>

    <p>Best regards,<br>
    {companyname}</p>",
    'sketchboard',
    'Share Sketchboard(Send to Staff)',
    'shared-sketchboard-to-staff'
);
