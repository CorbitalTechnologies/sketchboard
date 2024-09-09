<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sketchboard extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('sketchboard_model');
    }

    public function index()
    {
        $data['title'] = _l('sketchboard');

        $filteredStaff = array_filter($this->staff_model->get(), function ($staff) {
            return !isset($staff['admin']) || $staff['admin'] != 1;
        });
        $data['staff'] = array_values($filteredStaff);

        $this->load->view('manage', $data);
    }

    public function save()
    {
        if (!$this->input->is_ajax_request()) {
            ajax_access_denied();
        }
        $data     = $this->input->post();
        $response = $this->sketchboard_model->save($data);
        echo json_encode($response);
    }

    public function get_table_data()
    {
        if (!$this->input->is_ajax_request()) {
            ajax_access_denied();
        }
        $this->app->get_table_data(module_views_path(SKETCHBOARD_MODULE, 'tables/sketch_board'));
    }

    public function delete($id)
    {
        if (!empty($id)) {
            $res = $this->sketchboard_model->delete($id);
            set_alert($res['type'], $res['message']);
        }
        redirect(admin_url("sketchboard"));
    }

    public function board($id)
    {
        $data['title'] = _l('sketchboard');

        if (!empty($id)) {
            $data['board_info'] = $this->sketchboard_model->get($id);
        }

        $this->load->view('board', $data);
    }
}
