<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scheduler extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('WS_mods', 'ws');
    }

    public function insertpenyalur()
    {
        $result = $this->ws->getPenyalur();
        print_r($result);

    }

    public function updatereport()
    {
        $result = $this->ws->updateDebitur();
        ini_set('max_execution_time', 1000000000);

        print_r($result);
    }

    

}
