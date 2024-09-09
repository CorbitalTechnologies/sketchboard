<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('sb_get_staff_email')) {
    function sb_get_staff_email($staff_id)
    {
        $staff = get_instance()->db->get_where(db_prefix() . 'staff', ['staffid' => $staff_id])->row_array();
        return $staff['email'];
    }
}
