<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Sketchboard_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Title',
                'key'       => '{sketchboard_title}',
                'available' => [
                    'sketchboard',
                ],
                'templates' => [],
            ],
            [
                'name'      => 'Description',
                'key'       => '{sketchboard_description}',
                'available' => [
                    'sketchboard',
                ],
                'templates' => [],
            ],
            [
                'name'      => 'Created By',
                'key'       => '{sketchboard_created_by}',
                'available' => [
                    'sketchboard',
                ],
                'templates' => [],
            ],
            [
                'name'      => 'Sketchboard URL',
                'key'       => '{sketchboard_url}',
                'available' => [
                    'sketchboard',
                ],
                'templates' => [],
            ],
        ];
    }

    public function format($board_id)
    {
        $fields                                = [];

        $this->ci->load->model('sketchboard_model');
        $board = $this->ci->sketchboard_model->get($board_id);

        if (!$board) {
            return $fields;
        }

        $fields['{sketchboard_title}']         = $board['title'];
        $fields['{sketchboard_description}']   = $board['description'];
        $fields['{sketchboard_created_by}']    = get_staff_full_name($board['created_by']);
        $fields['{sketchboard_url}']           = admin_url('sketchboard/board/' . $board_id);

        return hooks()->apply_filters('sketchboard_merge_fields', $fields, ['id' => $board_id]);
    }
}
