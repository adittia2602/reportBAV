<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refresh extends CI_Controller
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

    public function reportpenyaluran()
    {
        $result = $this->ws->updateDebitur();
        print_r($result);
    }
    
    public function reportakad()
    {
        $result = $this->ws->updateAkadpembiayaan();
        print_r($result);
    }
    

}
