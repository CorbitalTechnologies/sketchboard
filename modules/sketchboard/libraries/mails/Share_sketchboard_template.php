<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Share_sketchboard_template extends App_mail_template
{

    public $slug = 'shared-sketchboard-to-staff';

    public $rel_type = 'sketchboard';
    protected $for   = 'sketchboard';

    protected $email;

    protected $staffid;
    protected $board_id;

    public function __construct($email, $staffid, $board_id)
    {
        parent::__construct();
        $this->email = $email;
        $this->staffid = $staffid;
        $this->board_id = $board_id;
    }

    public function build()
    {
        $this->to($this->email)->set_merge_fields('staff_merge_fields', $this->staffid)->set_merge_fields('sketchboard_merge_fields', $this->board_id);
    }
}
