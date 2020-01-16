<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencarian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
        $this->load->model('WS_mods', 'ws');
    }

    public function debitur()
    {
        $data['title'] = 'Debitur';
        $data['subtitle'] = 'Silahkan input NIK Debitur UMi';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['show'] = 'd-none';

        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[16]|max_length[16]');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data); // untuk memanggil template header
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('pencarian/debitur', $data);
            $this->load->view('templates/footer');
        } else {
            $nik = $this->input->post('nik');
            redirect('pencarian/debiturinfo/'.$nik);

        }
    }

    public function debiturinfo($nik)
    {


        $data['title'] = 'Debitur';
        $data['subtitle'] = 'Silahkan input NIK Debitur UMi';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['show'] = 'd-block';

        $data['debtor'] = $this->ws->fetchData('GET','debitur/'.$nik,'');
        ini_set('max_execution_time', 300);
        $data['found'] = empty($data['debtor']['NIK'])  ? '0' : '1';

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pencarian/debitur', $data);
        $this->load->view('templates/footer');

    }

}
