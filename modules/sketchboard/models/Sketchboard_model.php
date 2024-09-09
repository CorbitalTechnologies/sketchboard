<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sketchboard_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($data)
    {
        $insert = $update = false;
        $data['board_data'] = isset($data['board_data']) ? json_encode($data['board_data']) : '';
        $data['shared_to'] = isset($data['shared_to']) ? json_encode($data['shared_to']) : '';
        if (!empty($data['id'])) {
            $data['updated_by'] = get_staff_user_id();
            $old_board = $this->get($data['id']);
            $update = $this->db->update(db_prefix() . "sketchboard", $data, ['id' => $data['id']]);
            if ($update && !empty($data['shared_to'])) {
                $id = $data['id'];
                $new_shared = (!empty($old_board['shared_to'])) ? array_diff(json_decode($data['shared_to'], true), json_decode($old_board['shared_to'], true)) : json_decode($data['shared_to'], true);
                foreach ($new_shared as $staff_id) {
                    $staff_mail = sb_get_staff_email($staff_id);
                    send_mail_template('share_sketchboard_template', SKETCHBOARD_MODULE, $staff_mail, $staff_id, $id);
                    $notified = add_notification([
                        'description'     => _l('new_sketchboard_shared_with_you', $data['title']),
                        'touserid'        => $staff_id,
                        'fromuserid'      => get_staff_user_id(),
                        'link'            => 'sketchboard/board/' . $id,
                        'additional_data' => serialize([]),
                    ]);
                    if ($notified) {
                        pusher_trigger_notification([$staff_id]);
                    }
                }
            }
        } else {
            $data['created_by'] = get_staff_user_id();
            $insert = $this->db->insert(db_prefix() . "sketchboard", $data);
            if ($insert && !empty($data['shared_to'])) {
                $id = $this->db->insert_id();
                foreach (json_decode($data['shared_to']) as $staff_id) {
                    $staff_mail = sb_get_staff_email($staff_id);
                    send_mail_template('share_sketchboard_template', SKETCHBOARD_MODULE, $staff_mail, $staff_id, $id);
                    $notified = add_notification([
                        'description'     => _l('new_sketchboard_shared_with_you', $data['title']),
                        'touserid'        => $staff_id,
                        'fromuserid'      => get_staff_user_id(),
                        'link'            => 'sketchboard/board/' . $id,
                        'additional_data' => serialize([]),
                    ]);
                    if ($notified) {
                        pusher_trigger_notification([$staff_id]);
                    }
                }
            }
        }
        return [
            'type' => $insert || $update ? 'success' : 'danger',
            'message' => $insert ? _l('added_successfully', _l('sketch_board')) : ($update ? _l('updated_successfully', _l('sketch_board')) : _l('something_went_wrong')),
        ];
    }

    public function delete($id)
    {
        $delete = $this->db->delete(db_prefix() . "sketchboard", ['id' => $id]);
        return [
            'type' => 'danger',
            'message' => $delete ? _l('deleted', _l('sketch_board')) : _l('something_went_wrong'),
        ];
    }

    public function get($id)
    {
        if (!empty($id)) {
            return $this->db->get_where(db_prefix() . 'sketchboard', ['id' => $id])->row_array();
        }
        return $this->db->get(db_prefix() . 'sketchboard')->result_array();
    }
}
