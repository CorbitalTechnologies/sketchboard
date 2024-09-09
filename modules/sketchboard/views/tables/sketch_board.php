<?php
defined('BASEPATH') or exit('No direct script access allowed');

$columns = [
    'id',
    'title',
    'description',
    'shared_to',
];

$id      = 'id';
$table   = db_prefix() . 'sketchboard';

$where = [];

if (!is_admin()) {
    array_push($where, ' AND created_by = ' . get_staff_user_id() . ' OR JSON_CONTAINS(`shared_to`, ' . $this->ci->db->escape(json_encode(explode(',', get_staff_user_id()))) . ', "$")');
}

$result  = data_tables_init($columns, $id, $table, [], $where, ['id', 'created_by']);


$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $row[] = $aRow['title'];

    $row[] = mb_strimwidth($aRow['description'], 0, 100, '...');

    if (is_array(json_decode($aRow['shared_to']))) {
        $staff = array_map(function ($id) {
            return get_staff_full_name($id);
        }, json_decode($aRow['shared_to']));
        $shared_to = implode(', ', $staff);
    } else {
        $shared_to = get_staff_full_name($aRow['shared_to']) ?? '-';
    }
    $row[] = !empty($shared_to) ? $shared_to : '-';

    $options = '<div class="tw-flex tw-items-center tw-space-x-3">';

    if (is_admin() || $aRow['created_by'] == get_staff_user_id() || in_array(get_staff_user_id(), json_decode($aRow['shared_to'], true))) {
        $options .= '<a href="' . admin_url('sketchboard/board/' . $aRow['id']) . '" class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700" data-toggle="tooltip" data-title=' . _l('sketchboard') . '><i class="fa-solid fa-code-fork fa-lg"></i></a>';
    }

    if (is_admin() || $aRow['created_by'] == get_staff_user_id()) {
        $options .= '<a href="#" data-toggle="modal" data-table=".table-invoice-items" data-target="#items_bulk_actions" class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700 edit-btn update" data-id="' . $aRow['id'] . '" data-title="' . $aRow['title'] . '" data-description="' . $aRow['description'] . '" data-shared_to=' . $aRow['shared_to'] . '><i class="fa-regular fa-pen-to-square fa-lg"></i></a>';
    }

    if (is_admin() || $aRow['created_by'] == get_staff_user_id()) {
        $options .= '<a class="tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700 delete-btn _delete" href="' . admin_url('sketchboard/delete/' . $aRow['id']) . '"><i class="fa-regular fa-trash-can fa-lg"></i></a>';
    }

    $options .= '</div>';
    $row[] = $options;

    $output['aaData'][] = $row;
}
